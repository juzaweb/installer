<?php

namespace Juzaweb\Installer\Http\Controllers;

use Illuminate\Routing\Controller;
use Juzaweb\Installer\Events\InstallerFinished;
use Juzaweb\Installer\Helpers\EnvironmentManager;
use Juzaweb\Installer\Helpers\FinalInstallManager;
use Juzaweb\Installer\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \Juzaweb\Installer\Helpers\InstalledFileManager $fileManager
     * @param \Juzaweb\Installer\Helpers\FinalInstallManager $finalInstall
     * @param \Juzaweb\Installer\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function finish (
        InstalledFileManager $fileManager,
        FinalInstallManager $finalInstall,
        EnvironmentManager $environment
    )
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();

        event(new InstallerFinished());

        return view('installer::finished', compact(
            'finalMessages',
            'finalStatusMessage'
        ));
    }
}
