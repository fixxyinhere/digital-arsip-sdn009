<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use App\Services\DocumentAccessLogger;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewDocument extends ViewRecord
{
    protected static string $resource = DocumentResource::class;

    /**
     * Log ketika halaman detail dokumen dibuka
     */
    public function mount(int|string $record): void
    {
        parent::mount($record);

        // Log view action ketika page detail dibuka
        DocumentAccessLogger::logView($this->record->id, [
            'document_title' => $this->record->title,
            'document_number' => $this->record->document_number,
            'view_type' => 'filament_detail_page',
            'page_url' => request()->url(),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('download')
                ->label('Unduh File')
                ->icon('heroicon-m-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    // Log download
                    DocumentAccessLogger::logDownload($this->record->id, [
                        'document_title' => $this->record->title,
                        'document_number' => $this->record->document_number,
                        'file_name' => $this->record->original_name,
                        'download_method' => 'detail_page_action',
                    ]);

                    if (!\Storage::exists($this->record->file_path)) {
                        \Filament\Notifications\Notification::make()
                            ->title('File tidak ditemukan!')
                            ->danger()
                            ->send();
                        return;
                    }

                    return \Storage::download($this->record->file_path, $this->record->original_name);
                })
                ->visible(fn() => auth()->user()->can('download_documents')),

            Actions\EditAction::make()
                ->visible(fn() => auth()->user()->can('edit_documents')),

            Actions\DeleteAction::make()
                ->visible(fn() => auth()->user()->can('delete_documents')),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                // PREVIEW FILE SECTION
                Infolists\Components\Section::make('Preview Dokumen')
                    ->schema([
                        Infolists\Components\ViewEntry::make('file_preview')
                            ->label('')
                            ->view('filament.infolists.file-preview')
                            ->viewData(['record' => $this->record])
                            ->columnSpanFull(),
                    ])
                    ->visible(fn() => $this->canPreviewFile()),

                Infolists\Components\Section::make('Informasi Dokumen')
                    ->schema([
                        Infolists\Components\TextEntry::make('document_number')
                            ->label('Nomor Dokumen')
                            ->badge()
                            ->color('primary'),

                        Infolists\Components\TextEntry::make('title')
                            ->label('Judul Dokumen'),

                        Infolists\Components\TextEntry::make('category.name')
                            ->label('Kategori')
                            ->badge(),

                        Infolists\Components\TextEntry::make('documentType.name')
                            ->label('Tipe Dokumen')
                            ->badge()
                            ->color('info'),

                        Infolists\Components\TextEntry::make('confidentiality_label')
                            ->label('Tingkat Kerahasiaan')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'Publik' => 'success',
                                'Internal' => 'info',
                                'Rahasia' => 'warning',
                                'Sangat Rahasia' => 'danger',
                            }),

                        Infolists\Components\TextEntry::make('document_date')
                            ->label('Tanggal Dokumen')
                            ->date('d F Y'),

                        Infolists\Components\TextEntry::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Informasi File')
                    ->schema([
                        Infolists\Components\TextEntry::make('original_name')
                            ->label('Nama File'),

                        Infolists\Components\TextEntry::make('file_size_human')
                            ->label('Ukuran File'),

                        Infolists\Components\TextEntry::make('mime_type')
                            ->label('Tipe File'),

                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Diupload Pada')
                            ->dateTime('d F Y H:i'),

                        Infolists\Components\TextEntry::make('uploader.name')
                            ->label('Diupload oleh'),

                        Infolists\Components\IconEntry::make('is_active')
                            ->label('Status')
                            ->boolean(),
                    ])
                    ->columns(2),
            ]);
    }

    /**
     * Cek apakah file bisa di-preview
     */
    private function canPreviewFile(): bool
    {
        if (!$this->record->file_path || !\Storage::exists($this->record->file_path)) {
            return false;
        }

        $allowedMimeTypes = [
            'application/pdf',
            'image/jpeg',
            'image/jpg',
            'image/png',
            'image/gif',
            'text/plain',
        ];

        return in_array($this->record->mime_type, $allowedMimeTypes);
    }
}
