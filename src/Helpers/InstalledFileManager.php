<?php

namespace Juzaweb\Installer\Helpers;

class InstalledFileManager
{
    /**
     * Create installed file.
     *
     * @return int
     */
    public function create()
    {
        $installedLogFile = Intaller::installedPath();
        $dateStamp = date('Y/m/d h:i:sa');

        if (!file_exists($installedLogFile)) {
            $message = trans('installer::installer_messages.installed.success_log_message').$dateStamp."\n";

            file_put_contents($installedLogFile, $message);
        } else {
            $message = trans('installer::installer_messages.updater.log.success_message').$dateStamp;

            file_put_contents($installedLogFile, $message.PHP_EOL, FILE_APPEND | LOCK_EX);
        }

        return $message;
    }

    /**
     * Update installed file.
     *
     * @return int
     */
    public function update()
    {
        return $this->create();
    }
}
