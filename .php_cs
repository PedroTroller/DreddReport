<?php

$finder = Symfony\CS\Finder\DefaultFinder::create();

if (is_dir(sprintf('%s/src', __DIR__))) {
    $finder->in('src/');
}

if (is_dir(sprintf('%s/spec', __DIR__))) {
    $finder->in('spec/');
}

if (is_dir(sprintf('%s/features', __DIR__))) {
    $finder->in('features/');
}

if (is_dir(sprintf('%s/web', __DIR__))) {
    $finder->in('web/');
}

if (is_dir(sprintf('%s/var', __DIR__)) && is_dir(sprintf('%s/app', __DIR__))) {
    $finder->in('app/');
}

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers(array(
        'align_double_arrow',
        'align_equals',
        'concat_with_spaces',
        'header_comment',
        'line_break_between_statements',
        'mbstring',
        'newline_after_open_tag',
        'ordered_use',
        'phpdoc_order',
        'phpspec',
        'short_array_syntax',
        'single_comment_collapsed',
    ))
    ->addCustomFixer(new PedroTroller\CS\Fixer\Contrib\LineBreakBetweenStatementsFixer())
    ->addCustomFixer(new PedroTroller\CS\Fixer\Contrib\MbstringFixer())
    ->addCustomFixer(new PedroTroller\CS\Fixer\Contrib\PhpspecFixer())
    ->addCustomFixer(new PedroTroller\CS\Fixer\Contrib\SingleCommentCollapsedFixer())
    ->finder($finder)
;
