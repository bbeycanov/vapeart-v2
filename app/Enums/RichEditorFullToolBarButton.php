<?php

namespace App\Enums;

enum RichEditorFullToolBarButton: string
{
    case Bold = 'bold';
    case Italic = 'italic';
    case Underline = 'underline';

    case Strike = 'strike';
    case Subscript = 'subscript';
    case Superscript = 'superscript';
    case Link = 'link';
    case TextColor = 'textColor';
    case H1 = 'h1';
    case H2 = 'h2';
    case H3 = 'h3';
    case Blockquote = 'blockquote';

    case Code = 'code';
    case CodeBlock = 'codeBlock';
    case BulletList = 'bulletList';
    case OrderedList = 'orderedList';
    case Table = 'table';
    case TableAddColumnBefore = 'tableAddColumnBefore';
    case TableAddColumnAfter = 'tableAddColumnAfter';
    case TableDeleteColumn = 'tableDeleteColumn';
    case TableAddRowBefore = 'tableAddRowBefore';
    case TableAddRowAfter = 'tableAddRowAfter';
    case TableDeleteRow = 'tableDeleteRow';
    case TableMergeCells = 'tableMergeCells';
    case TableSplitCell = 'tableSplitCell';
    case TableToggleHeaderRow = 'tableToggleHeaderRow';
    case TableDelete = 'tableDelete';
    case AttachFiles = 'attachFiles';
    case CustomBlocks = 'customBlocks';
    case MergeTags = 'mergeTags';
    case HorizontalRule = 'horizontalRule';
    case Highlight = 'highlight';
    case Small = 'small';
    case Lead = 'lead';
    case Undo = 'undo';
    case Redo = 'redo';
    case AlignStart = 'alignStart';
    case AlignCenter = 'alignCenter';
    case AlignEnd = 'alignEnd';
    case AlignJustify = 'alignJustify';
    case Grid = 'grid';
    case GridDelete = 'gridDelete';
    case Details = 'details';
    case ClearFormatting = 'clearFormatting';

    /**
     * @return array
     */
    public static function getAll(): array
    {
        return [
            self::Bold->value,
            self::Italic->value,
            self::Underline->value,
            self::Strike->value,
            //  self::Subscript->value,
            //  self::Superscript->value,
            self::Link->value,
            self::TextColor->value,
            self::H1->value,
            self::H2->value,
            self::H3->value,
            self::Blockquote->value,
            self::Code->value,
            self::CodeBlock->value,
            self::BulletList->value,
            self::OrderedList->value,
            self::Table->value,
            //    self::TableAddColumnBefore->value,
            //    self::TableAddColumnAfter->value,
            //    self::TableDeleteColumn->value,
            //    self::TableAddRowBefore->value,
            //    self::TableAddRowAfter->value,
            //    self::TableDeleteRow->value,
            //    self::TableMergeCells->value,
            //    self::TableSplitCell->value,
            //    self::TableToggleHeaderRow->value,
            //    self::TableDelete->value,
            self::AttachFiles->value,
            self::CustomBlocks->value,
            self::MergeTags->value,
            self::HorizontalRule->value,
            self::Highlight->value,
            self::Small->value,
            self::Lead->value,
            self::Undo->value,
            self::Redo->value,
            self::AlignStart->value,
            self::AlignCenter->value,
            self::AlignEnd->value,
            self::AlignJustify->value,
            self::Grid->value,
            // self::GridDelete->value,
            self::Details->value,
            //  self::ClearFormatting->value,
        ];
    }
}
