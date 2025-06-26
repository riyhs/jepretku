<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Galeriku') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 md:px-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                @foreach ($snapshots as $snapshot)
                    <div id="snapshot-card-{{ $snapshot->id }}"
                        class="group bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-[0_0_25px_10px_rgba(251,146,60,0.4)]  transition-shadow duration-300">

                        <div class="relative">
                            <img src="{{ route('snapshots.image', $snapshot->id) }}" alt="{{ $snapshot->title }}"
                                class="w-full h-48 object-cover pt-3">

                            <div
                                class="absolute inset-0 bg-black/50 lg:bg-transparent group-hover:bg-black/50 transition-all duration-300 flex items-center justify-center space-x-4">
                                <div
                                    class="flex space-x-3 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity duration-300">

                                    <button title="Lihat Foto"
                                        class="view-button p-2 rounded-full bg-white hover:bg-gray-200"
                                        data-src="{{ route('snapshots.image', $snapshot) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </button>

                                    <a href="{{ route('snapshots.download', $snapshot) }}" title="Download" download
                                        class="p-2 rounded-full bg-white hover:bg-gray-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                    </a>

                                    <button title="Hapus"
                                        class="delete-button p-2 rounded-full bg-red-500 hover:bg-red-600"
                                        data-delete-url="{{ route('snapshots.destroy', $snapshot) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="p-4">
                            <div id="display-area-{{ $snapshot->id }}">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 id="snapshot-title-{{ $snapshot->id }}" class="font-bold text-lg truncate">
                                            {{ $snapshot->title }}</h3>
                                        <p class="text-sm text-gray-500">
                                            {{ $snapshot->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                    <div class="flex space-x-2 flex-shrink-0">
                                        <button title="Ganti Judul"
                                            class="edit-button text-gray-400 hover:text-orange-400"
                                            data-snapshot-id="{{ $snapshot->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fill-rule="evenodd"
                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <button title="Bagikan" class="share-button text-gray-400 hover:text-pink-500"
                                            data-title="{{ $snapshot->title }}" data-url="{{ url()->current() }}"
                                            data-image-url="{{ route('snapshots.image', $snapshot) }}"
                                            data-filename="{{ basename($snapshot->path) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="edit-area-{{ $snapshot->id }}" class="hidden">
                                <div class="space-y-2">
                                    <input type="text" value="{{ $snapshot->title }}"
                                        class="title-input w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <div class="flex justify-end space-x-2">
                                        <button class="cancel-button text-sm text-gray-600 hover:text-gray-900"
                                            data-snapshot-id="{{ $snapshot->id }}">Batal</button>
                                        <button
                                            class="save-button text-sm px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                                            data-update-url="{{ route('snapshots.update', $snapshot) }}"
                                            data-snapshot-id="{{ $snapshot->id }}">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <div id="manual-share-popup"
                class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm relative">
                    <button id="close-share-popup"
                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">&times;</button>

                    <h3 class="font-bold text-lg mb-4">Bagikan Foto</h3>
                    <p id="share-title-preview" class="text-sm text-gray-600 mb-4 truncate"></p>

                    <div class="flex justify-around items-center text-center">
                        <a id="share-facebook" href="#" target="_blank" class="text-gray-700 hover:text-blue-600">
                            <svg class="w-10 h-10 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v2.385z" />
                            </svg>
                            <span class="text-xs">Facebook</span>
                        </a>
                        <a id="share-twitter" href="#" target="_blank"
                            class="text-gray-700 hover:text-sky-500">
                            <svg class="w-10 h-10 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616v.064c0 2.296 1.634 4.208 3.803 4.649-.626.17-1.294.219-1.985.174.593 1.864 2.313 3.227 4.35 3.264-1.624 1.274-3.667 2.03-5.883 2.03-.38 0-.755-.022-1.124-.067 2.099 1.352 4.606 2.148 7.321 2.148 8.642 0 13.59-6.948 13.237-13.337.933-.673 1.731-1.511 2.367-2.45z" />
                            </svg>
                            <span class="text-xs">Twitter</span>
                        </a>
                        <a id="share-whatsapp" href="#" target="_blank"
                            class="text-gray-700 hover:text-green-500">
                            <svg class="w-10 h-10 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.894 11.892-1.99 0-3.903-.52-5.586-1.456l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.886-.001 2.267.755 4.282 2.161 5.943l-.31 1.141z" />
                            </svg>
                            <span class="text-xs">WhatsApp</span>
                        </a>
                    </div>
                    <div class="mt-4 pt-4 border-t">
                        <input id="share-url-input" type="text" readonly
                            class="w-full border-gray-300 rounded-md shadow-sm text-sm p-2 bg-gray-100">
                        <button id="copy-share-url"
                            class="w-full mt-2 text-sm bg-gray-200 hover:bg-gray-300 rounded-md p-2">Salin
                            Link</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            document.body.addEventListener('click', function(event) {
                const button = event.target.closest('button');
                if (!button) return;

                const snapshotId = button.dataset.snapshotId;

                if (button.classList.contains('delete-button')) {
                    event.preventDefault();
                    if (confirm(
                            'Apakah Anda yakin ingin menghapus foto ini? Tindakan ini tidak bisa dibatalkan.'
                        )) {
                        const deleteUrl = button.getAttribute('data-delete-url');
                        fetch(deleteUrl, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    document.getElementById('snapshot-card-' + deleteUrl.split('/')
                                        .pop()).remove();
                                } else {
                                    alert('Error: ' + data.message);
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    }
                }

                if (button.classList.contains('edit-button')) {
                    document.getElementById('display-area-' + snapshotId).classList.add('hidden');
                    document.getElementById('edit-area-' + snapshotId).classList.remove('hidden');
                }

                if (button.classList.contains('cancel-button')) {
                    document.getElementById('display-area-' + snapshotId).classList.remove('hidden');
                    document.getElementById('edit-area-' + snapshotId).classList.add('hidden');
                }

                if (button.classList.contains('save-button')) {
                    const updateUrl = button.dataset.updateUrl;
                    const editArea = document.getElementById('edit-area-' + snapshotId);
                    const newTitle = editArea.querySelector('.title-input').value;

                    fetch(updateUrl, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                title: newTitle
                            })
                        })
                        .then(response => {
                            if (!response.ok) {

                                return response.json().then(err => {
                                    throw err;
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                document.getElementById('snapshot-title-' + snapshotId).textContent =
                                    data.new_title;
                                document.getElementById('display-area-' + snapshotId).classList.remove(
                                    'hidden');
                                document.getElementById('edit-area-' + snapshotId).classList.add(
                                    'hidden');
                            }
                        })
                        .catch(error => {

                            let errorMessage = 'Terjadi kesalahan.';
                            if (error.errors && error.errors.title) {
                                errorMessage = error.errors.title[0];
                            } else if (error.message) {
                                errorMessage = error.message;
                            }
                            alert(errorMessage);
                            console.error('Error:', error);
                        });
                }

                if (button.classList.contains('view-button')) {
                    const imageUrl = button.dataset.src;

                    if (imageUrl) {
                        basicLightbox.create(`
                        <img src="${imageUrl}" style="max-width: 90vw; max-height: 90vh;">
                    `).show();
                    }
                }

                if (button.classList.contains('share-button')) {
                    const sharePhoto = async () => {
                        const shareTitle = button.dataset.title;
                        const pageUrl = button.dataset.url;
                        const imageUrl = button.dataset.imageUrl;
                        const filename = button.dataset.filename;

                        if (!navigator.share) {
                            showManualSharePopup(shareTitle, pageUrl);
                            return;
                        }

                        try {
                            const response = await fetch(imageUrl);
                            const blob = await response.blob();
                            const file = new File([blob], filename, {
                                type: blob.type
                            });

                            if (navigator.canShare && navigator.canShare({
                                    files: [file]
                                })) {
                                await navigator.share({
                                    files: [file],
                                    title: shareTitle,
                                    text: `Lihat foto keren ini: ${shareTitle}`,
                                });
                                console.log('File berhasil dibagikan.');
                            } else {
                                await navigator.share({
                                    title: shareTitle,
                                    text: `Lihat foto keren ini: ${shareTitle}`,
                                    url: pageUrl,
                                });
                                console.log('Link berhasil dibagikan.');
                            }
                        } catch (error) {
                            console.log('Gagal membagikan:', error);
                            showManualSharePopup(shareTitle, pageUrl);
                        }
                    };
                    sharePhoto();
                }

                if (button.id === 'close-share-popup') {
                    button.closest('#manual-share-popup').classList.add('hidden');
                }

                if (button.id === 'copy-share-url') {
                    const urlInput = document.getElementById('share-url-input');
                    urlInput.select();
                    document.execCommand('copy');
                    button.textContent = 'Berhasil disalin!';
                    setTimeout(() => {
                        button.textContent = 'Salin Link';
                    }, 2000);
                }
            });

            const sharePopup = document.getElementById('manual-share-popup');
            sharePopup.addEventListener('click', function(event) {
                if (event.target === this) {
                    this.classList.add('hidden');
                }


            });

            function showManualSharePopup(title, url) {
                const popup = document.getElementById('manual-share-popup');
                const urlEncoded = encodeURIComponent(url);
                const textEncoded = encodeURIComponent(`Lihat foto keren ini: ${title}`);

                popup.querySelector('#share-title-preview').textContent = title;
                popup.querySelector('#share-facebook').href =
                    `https://www.facebook.com/sharer/sharer.php?u=${urlEncoded}`;
                popup.querySelector('#share-whatsapp').href =
                    `https://api.whatsapp.com/send?text=${textEncoded}%20${urlEncoded}`;
                popup.querySelector('#share-url-input').value = url;

                popup.classList.remove('hidden');
            }

        });
    </script>

</x-app-layout>
