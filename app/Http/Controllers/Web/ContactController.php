<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Enums\BannerPosition;
use Illuminate\Http\Request;
use Spatie\SchemaOrg\Schema;
use App\Mail\ContactMessageMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\View\Factory;
use App\Services\Contracts\BranchServiceInterface;
use App\Services\Contracts\BannerServiceInterface;
use App\Services\Contracts\ContactMessageServiceInterface;

class ContactController extends Controller
{
    /**
     * @param BranchServiceInterface $branches
     * @param ContactMessageServiceInterface $contactMessages
     * @param BannerServiceInterface $bannerService
     */
    public function __construct(
        private readonly BranchServiceInterface         $branches,
        private readonly ContactMessageServiceInterface $contactMessages,
        private readonly BannerServiceInterface         $bannerService
    )
    {
    }

    /**
     * @param string $locale
     * @return Factory|View
     */
    public function index(string $locale): Factory|View
    {
        app()->setLocale($locale);

        $branches = $this->branches->getAllActive();

        $defaultBranch = $this->branches->getDefault() ?? $branches->first();

        $schemaJsonLd = $this->buildSchemaFor($branches);

        // Get page header banner for contact page
        $pageBanner = $this->bannerService->byPosition(BannerPosition::PAGE_HEADER)
            ->where('key', 'contact-page-header')
            ->first();

        return view('pages.contacts.index', compact('branches', 'defaultBranch', 'schemaJsonLd', 'pageBanner'));
    }

    /**
     * @param Collection $branches
     * @return string
     */
    private function buildSchemaFor(Collection $branches): string
    {
        $locale = app()->getLocale();

        $url = route('contacts.index', ['locale' => $locale]);

        $webPage = Schema::webPage()
            ->name(__('Contact Us'))
            ->url($url)
            ->inLanguage($locale)
            ->description(__('Get in touch with us'));

        $breadcrumb = Schema::breadcrumbList()->itemListElement([
            Schema::listItem()->position(1)->name(__('Home'))->item(url('/')),
            Schema::listItem()->position(2)->name(__('Contact Us'))->item($url),
        ]);

        $schemaScripts = $webPage->toScript() . PHP_EOL . $breadcrumb->toScript();

        foreach ($branches as $branch) {
            $name = $branch->getTranslation('name', $locale);
            $address = $branch->getTranslation('address', $locale);

            $localBusiness = Schema::localBusiness()
                ->name($name);

            if ($branch->phone) {
                $localBusiness->telephone($branch->phone);
            }

            if ($branch->email) {
                $localBusiness->email($branch->email);
            }

            if ($address) {
                $postalAddress = Schema::postalAddress();

                $addressLines = explode("\n", $address);
                if (count($addressLines) > 0) {
                    $postalAddress->streetAddress(trim($addressLines[0]));
                }
                if (count($addressLines) > 1) {
                    $postalAddress->addressLocality(trim($addressLines[1]));
                }

                $localBusiness->address($postalAddress);
            }

            if ($branch->latitude && $branch->longitude) {
                $geo = Schema::geoCoordinates()
                    ->latitude((float)$branch->latitude)
                    ->longitude((float)$branch->longitude);
                $localBusiness->geo($geo);
            }

            $schemaScripts .= PHP_EOL . $localBusiness->toScript();
        }

        return $schemaScripts;
    }

    /**
     * @param string $locale
     * @param Request $request
     * @return JsonResponse
     */
    public function store(string $locale, Request $request): JsonResponse
    {
        app()->setLocale($locale);

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'message' => 'required|string|max:5000',
            ], [
                'name.required' => __('The name field is required.'),
                'name.max' => __('The name may not be greater than :max characters.', ['max' => 255]),
                'email.required' => __('The email field is required.'),
                'email.email' => __('Please enter a valid email address.'),
                'email.max' => __('The email may not be greater than :max characters.', ['max' => 255]),
                'message.required' => __('The message field is required.'),
                'message.max' => __('The message may not be greater than :max characters.', ['max' => 5000]),
            ]);

            $contactMessage = $this->contactMessages->create($validated);

            $adminEmail = config('mail.contact_to_address', config('mail.from.address'));

            if ($adminEmail) {
                try {
                    Mail::to($adminEmail)->send(new ContactMessageMail($contactMessage));
                } catch (Exception $mailException) {
                    Log::error('Contact form mail error: ' . $mailException->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'message' => __('Your message has been sent successfully. We will contact you soon.')
            ]);
        } catch (Exception $e) {
            Log::error('Contact form error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => __('An error occurred. Please try again later.')
            ], 500);
        }
    }
}

