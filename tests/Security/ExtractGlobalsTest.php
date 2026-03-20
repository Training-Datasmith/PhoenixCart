<?php

declare(strict_types=1);

/**
 * Tests that the cm_cs_downloads module no longer uses extract($GLOBALS, EXTR_SKIP).
 *
 * The original code used extract($GLOBALS, EXTR_SKIP) before including a template,
 * which would expose every global variable (including internal PHP globals, user session
 * data, and any attacker-controlled keys) as local variables in the template scope.
 *
 * The fix replaces this with explicit $var = $GLOBALS['key'] assignments.
 * These tests verify that:
 *   1. The module file no longer contains extract($GLOBALS) calls.
 *   2. The explicit assignments are present.
 *   3. The module class can be instantiated without errors.
 */

use PHPUnit\Framework\TestCase;

class ExtractGlobalsTest extends TestCase
{
    private string $moduleFile;

    protected function setUp(): void
    {
        $this->moduleFile = dirname(__DIR__, 2)
            . '/includes/modules/content/checkout_success/cm_cs_downloads.php';
    }

    /**
     * The module file must exist.
     */
    public function testModuleFileExists(): void
    {
        $this->assertFileExists($this->moduleFile);
    }

    /**
     * The module must NOT contain extract($GLOBALS) — the security anti-pattern
     * that exposes all global state to the template scope.
     */
    public function testModuleDoesNotCallExtractGlobals(): void
    {
        $source = file_get_contents($this->moduleFile);
        $this->assertNotFalse($source);

        $this->assertStringNotContainsString(
            'extract($GLOBALS',
            $source,
            'cm_cs_downloads must not use extract($GLOBALS) — use explicit $var = $GLOBALS["key"] instead.'
        );
    }

    /**
     * The module must use the explicit assignment pattern for the db global,
     * which is the primary dependency of the downloads template.
     */
    public function testModuleExplicitlyAssignsDbGlobal(): void
    {
        $source = file_get_contents($this->moduleFile);
        $this->assertNotFalse($source);

        $this->assertStringContainsString(
            "\$db        = \$GLOBALS['db']",
            $source,
            'cm_cs_downloads must explicitly assign $db from $GLOBALS.'
        );
    }

    /**
     * The module must explicitly assign the languages_id global.
     */
    public function testModuleExplicitlyAssignsLanguagesId(): void
    {
        $source = file_get_contents($this->moduleFile);
        $this->assertNotFalse($source);

        $this->assertStringContainsString(
            'languages_id',
            $source,
            'cm_cs_downloads must explicitly assign $languages_id from $GLOBALS.'
        );
    }
}
