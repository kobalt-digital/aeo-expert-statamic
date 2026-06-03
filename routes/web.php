<?php

use Illuminate\Support\Facades\Route;
use KobaltDigital\AeoExpert\Http\Controllers\LlmsTxtController;
use KobaltDigital\AeoExpert\Http\Controllers\RobotsTxtController;
use KobaltDigital\AeoExpert\Http\Controllers\WellKnownController;

// llms.txt
Route::get('llms.txt', [LlmsTxtController::class, 'show'])
    ->name('aeo-expert.llms-txt');

Route::get('.well-known/llms.txt', [LlmsTxtController::class, 'show'])
    ->name('aeo-expert.well-known-llms-txt');

// robots.txt (only if no physical file exists)
Route::get('robots.txt', [RobotsTxtController::class, 'show'])
    ->name('aeo-expert.robots-txt');

// .well-known endpoints
Route::get('.well-known/mcp', [WellKnownController::class, 'mcp'])
    ->name('aeo-expert.well-known-mcp');

Route::get('.well-known/security.txt', [WellKnownController::class, 'securityTxt'])
    ->name('aeo-expert.well-known-security-txt');

Route::get('.well-known/agent-skills.json', [WellKnownController::class, 'agentSkills'])
    ->name('aeo-expert.well-known-agent-skills');

Route::get('.well-known/api-catalog', [WellKnownController::class, 'apiCatalog'])
    ->name('aeo-expert.well-known-api-catalog');

Route::get('.well-known/oauth-authorization-server', [WellKnownController::class, 'oauthAuthorizationServer'])
    ->name('aeo-expert.well-known-oauth-as');

Route::get('.well-known/oauth-protected-resource', [WellKnownController::class, 'oauthProtectedResource'])
    ->name('aeo-expert.well-known-oauth-pr');

