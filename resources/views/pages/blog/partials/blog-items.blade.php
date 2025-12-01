@foreach($blogs as $blog)
    <x-blog-card :blog="$blog" variant="index" />
@endforeach

