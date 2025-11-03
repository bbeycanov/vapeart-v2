<?php

namespace App\Support\Traits;

use Illuminate\Database\Eloquent\Model;

trait BuildsTreePath
{
    /**
     * @return string
     */
    protected function getParentColumn(): string
    {
        return property_exists($this, 'treeParentColumn') ? $this->treeParentColumn : 'parent_id';
    }

    /**
     * @return string
     */
    protected function getDepthColumn(): string
    {
        return property_exists($this, 'treeDepthColumn') ? $this->treeDepthColumn : 'depth';
    }

    /**
     * @return string
     */
    protected function getPathColumn(): string
    {
        return property_exists($this, 'treePathColumn') ? $this->treePathColumn : 'path';
    }

    /**
     * @param int|null $parentId
     * @return array
     */
    protected function computePathAndDepth(?int $parentId): array
    {
        if (is_null($parentId)) {
            return [
                'depth' => 0,
                'path' => '/',
            ];
        }

        $pk = $this->getKeyName();
        $depthC = $this->getDepthColumn();
        $pathC = $this->getPathColumn();

        /** @var Model|null $parent */
        $parent = static::query()
            ->select([
                $pk,
                $depthC,
                $pathC
            ])
            ->find($parentId);

        if (!$parent) {
            return [
                'depth' => 0,
                'path' => '/',
            ];
        }

        $depth = (int)($parent->{$depthC} ?? 0) + 1;
        $base = rtrim($parent->{$pathC} ?? '/', '/');
        $path = $base . '/' . $parent->{$pk} . '/';

        return compact('depth', 'path');
    }

    /**
     * @param Model $node
     * @return void
     */
    protected function cascadeRecomputeChildren(Model $node): void
    {
        $primaryKeyColumn = $this->getKeyName();
        $parentColumn = $this->getParentColumn();
        $depthColumn = $this->getDepthColumn();
        $pathColumn = $this->getPathColumn();

        $children = static::query()
            ->select([
                $primaryKeyColumn,
                $parentColumn,
                $depthColumn,
                $pathColumn
            ])
            ->where($parentColumn, $node->{$primaryKeyColumn})
            ->get();

        foreach ($children as $child) {
            $new = $this->computePathAndDepth($child->{$parentColumn});

            $child->{$depthColumn} = $new['depth'];
            $child->{$pathColumn} = rtrim($node->{$pathColumn} ?? '/', '/') . '/' . $node->{$primaryKeyColumn} . '/';
            $child->save();

            $this->cascadeRecomputeChildren($child);
        }
    }
}
