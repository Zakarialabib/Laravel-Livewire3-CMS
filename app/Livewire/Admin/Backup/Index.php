<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Backup;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Throwable;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use LivewireAlert;

    public $data = [];

    public $clientId;

    public $clientSecret;

    public $refreshToken;

    public $folderId;

    public $settingsModal = false;

    protected $listeners = [
        'deleteModel', 'generate',
        'refreshTable' => '$refresh',
        'delete',
    ];

    public function settingsModal(): void
    {
        // $this->backup_status = settings()->backup_status;
        // $this->backup_schedule = settings()->backup_schedule;
        $this->settingsModal = true;
    }

    public function saveToDriveManually(string $filename): void
    {
        $fileData = Storage::get($filename);
        Storage::cloud()->put(env('APP_NAME').'/'.$filename, $fileData);

        $this->alert('success', __('Backup saved to Google Drive successfully!'));
    }

    public function getContentsProperty()
    {
        $mainDisk = Storage::disk('google_backups');

        return $mainDisk->listContents('', true /* is_recursive */);
    }

    public function generate(): void
    {
        try {
            Artisan::call('backup:run');

            $this->alert('success', __('Backup Generated with success.'));
        } catch (Throwable) {
            $this->alert('success', __('Database backup failed.'));
        }
    }

    public function downloadBackup($file)
    {
        return Storage::download($file);
    }

    public function updateSettigns(): void
    {
        try {
            $this->validate();

            // settings()->update([
            //     'backup_status'   => $this->backup_status,
            //     'backup_schedule' => $this->backup_schedule,
            // ]);

            Config::set('filesystems.disks.google.clientId', $this->clientId);
            Config::set('filesystems.disks.google.clientSecret', $this->clientSecret);
            Config::set('filesystems.disks.google.refreshToken', $this->refreshToken);
            Config::set('filesystems.disks.google.folderId', $this->folderId);

            $this->alert('success', __('Settings backuped saved.'));

            $this->settingsModal = false;
        } catch (Throwable $throwable) {
            $this->alert('success', __('Failed.'.$throwable->getMessage()));
        }
    }

    public function delete($name): void
    {
        foreach (glob(storage_path().'/app/*') as $filename) {
            $path = storage_path().'/app/'.basename((string) $name);

            if (file_exists($path)) {
                @unlink($path);
            }
        }
    }

    public function render()
    {
        $backups = Storage::allFiles(env('APP_NAME'));

        return view('livewire.admin.backup.index', [
            'backups' => $backups,
        ]);
    }
}
