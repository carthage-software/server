<?php

declare(strict_types=1);

return (new PhpCsFixer\Config())
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in([
                __DIR__.'/bin',
                __DIR__.'/config',
                __DIR__.'/src',
                __DIR__.'/tests',
            ])
            ->append([__FILE__]),
    )
    ->setCacheFile(__DIR__.'/var/.php-cs-fixer/php-cs-fixer.cache')
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'align_multiline_comment' => true,
        'array_indentation' => true,
        'declare_strict_types' => true,
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => true,
            'import_functions' => true,
        ],
        'list_syntax' => [
            'syntax' => 'short',
        ],

        'nullable_type_declaration_for_default_null_value' => [
            'use_nullable_type_declaration' => true,
        ],
        'lowercase_cast' => true,
        'multiline_comment_opening_closing' => true,
        'native_function_casing' => true,
        'no_leading_import_slash' => true,
        'no_superfluous_phpdoc_tags' => [
            'allow_mixed' => true,
        ],
        'no_unused_imports' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'ordered_imports' => [
            'imports_order' => ['class', 'function', 'const'],
        ],
        'ordered_interfaces' => true,
        'php_unit_test_annotation' => true,
        'php_unit_test_case_static_method_calls' => [
            'call_type' => 'self',
        ],
        'single_import_per_statement' => true,
        'single_trait_insert_per_statement' => true,
        'static_lambda' => true,
        'strict_comparison' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_empty_phpdoc' => true,
        'phpdoc_align' => [
            'align' => 'left',
        ],
        'phpdoc_indent' => true,
        'phpdoc_line_span' => [
            'const' => 'multi',
            'property' => 'multi',
            'method' => 'multi',
        ],
        'phpdoc_no_alias_tag' => [
            'replacements' => [
                'psalm-var' => 'var',
                'psalm-template' => 'template',
                'psalm-param' => 'param',
                'psalm-return' => 'return',
            ],
        ],
        'phpdoc_order' => true,
        'phpdoc_scalar' => true,
        'phpdoc_separation' => true,
        'phpdoc_summary' => true,
        'phpdoc_tag_casing' => true,
        'phpdoc_trim' => true,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'no_empty_statement' => true,
        'semicolon_after_instruction' => true,
        'strict_param' => true,
        'header_comment' => false,
    ]);
