<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Photobooth') }}
        </h2>
    </x-slot>

    <style>
        #filter,
        #timer {
            margin: 10px 0;
        }

        #canvas {
            border: 1px solid #999;
            width: 270px;
            height: 690px;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col">
                        <div class="flex flex-row">
                            <div id="timer" class="flex-1 flex justify-center items-center">
                                <label for="timerSelect">Timer : </label>
                                <select id="timerSelect">
                                    <option value="0">0s</option>
                                    <option value="3">3s</option>
                                    <option value="5">5s</option>
                                    <option value="10">10s</option>
                                </select>
                            </div>

                            <div id="filter" class="flex-1 flex justify-center items-center ">
                                <label for="filterSelect">Filter : </label>
                                <select id="filterSelect">
                                    <option value="none">None</option>
                                    <option value="grayscale">Grayscale</option>
                                    <option value="sepia">Sepia</option>
                                    <option value="retro">Retro</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-row flex-1 justify-center items-center">
                            <div class="flex gap-4">
                                <div class="flex flex-col gap-4 items-center">
                                    <div style="position: relative; width:600px; height:450px;">
                                        <video id="video" autoplay playsinline
                                            style="border:1px solid#999; width:100%; height:100%;">
                                        </video>
                                        <div id="countdownDisplay"
                                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 100px; color: white; text-shadow: 2px 2px 8px rgba(0,0,0,0.7); display: none;">
                                        </div>
                                    </div>

                                    <div class="btn-group">
                                        <button id="captureBtn"
                                            class="px-6 py-3 bg-red-400 hover:bg-orange-600 rounded-lg text-white font-semibold">Capture</button>
                                        <button id="retakeBtn">Retake</button>
                                        <button id="nextBtn">Next</button>
                                        <button id="saveBtn">Save as JPG</button>
                                    </div>
                                </div>
                                <canvas id="canvas" width="270" height="690"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>
    <script>
        const width = 270;
        const height = 690;
        const padding = 10;

        let uploadedImages = [];
        let step = 0;
        let state = 'capture';
        let timerInterval = null;

        let captureButton = document.getElementById('captureBtn');
        let retakeButton = document.getElementById('retakeBtn');
        let nextButton = document.getElementById('nextBtn');
        let saveButton = document.getElementById('saveBtn');

        const timerSelect = document.getElementById('timerSelect');
        const countdownDisplay = document.getElementById('countdownDisplay');

        applyButtonState();

        // Initialize webcam
        const video = document.getElementById('video');
        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(stream => video.srcObject = stream)
            .catch(err => alert('Camera error: ' + err));

        // Initialize Fabric canvas 
        const canvas = new fabric.Canvas('canvas', {
            selection: false
        });

        captureButton.addEventListener('click', () => {
            const selectedTime = parseInt(timerSelect.value, 10);

            if (selectedTime === 0) {
                performCapture();
            } else {
                startTimer(selectedTime);
            }
        });

        // Timer
        function startTimer(duration) {
            captureButton.disabled = true;
            timerSelect.disabled = true;
            filterSelect.disabled = true;

            let timeLeft = duration;
            countdownDisplay.style.display = 'block';
            countdownDisplay.textContent = timeLeft;

            timerInterval = setInterval(() => {
                timeLeft--;
                countdownDisplay.textContent = timeLeft;

                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    countdownDisplay.style.display = 'none';
                    performCapture();

                    captureButton.disabled = false;
                    timerSelect.disabled = false;
                    filterSelect.disabled = false;
                }
            }, 1000);
        }

        // Capture
        function performCapture() {
            const tmp = document.createElement('canvas');
            tmp.width = video.videoWidth;
            tmp.height = video.videoHeight;
            tmp.getContext('2d').drawImage(video, 0, 0);

            const dataURL = tmp.toDataURL();
            fabric.Image.fromURL(dataURL, img => {
                const targetWidth = width - (2 * padding); // Contoh: 270 - 20 = 250px
                const targetHeight = (targetWidth * 3) / 4; // Contoh: (250 * 3) / 4 = 187.5px

                const scaleX = targetWidth / img.width;
                const scaleY = targetHeight / img.height;

                img.set({
                    scaleX,
                    scaleY,
                    originX: 'left',
                    originY: 'top',
                    selectable: false,
                    evented: false
                });

                uploadedImages[step] = img;
                stackAndRender();
                changeState('evaluate');
            });
        }


        // Retake button
        retakeButton.addEventListener('click', () => {
            changeState('capture')
        })

        // Next button
        nextButton.addEventListener('click', () => {
            step++;
            changeState('capture')
        })

        // --- MANAGE STATE ----
        function changeState(newState) {
            state = newState;
            applyButtonState();
        }

        function applyButtonState() {
            captureButton.hidden = (state === 'evaluate');
            retakeButton.hidden = (state === 'capture');
            nextButton.hidden = (state === 'capture' || step === 2);
            saveButton.hidden = (state === 'capture' || step < 2);
        }

        // Position each image and render
        function stackAndRender() {
            canvas.clear();
            canvas.backgroundColor = '#ffffff';

            let y = padding;
            uploadedImages.forEach(img => {
                img.set({
                    left: padding,
                    top: y
                });
                canvas.add(img);
                y += (height / 3.3);
            });

            applyFilterToAll();
            addJepretkuText();

            canvas.requestRenderAll();
        }

        // --- FILTER HANDLING ---
        const filterSelect = document.getElementById('filterSelect');
        filterSelect.addEventListener('change', () => {
            applyFilterToAll();
            canvas.requestRenderAll();
        });

        function applyFilterToAll() {
            const choice = filterSelect.value;

            uploadedImages.forEach(img => {
                let filters = [];
                if (choice === 'grayscale') {
                    filters.push(new fabric.Image.filters.Grayscale());
                } else if (choice === 'sepia') {
                    filters.push(new fabric.Image.filters.Sepia());
                } else if (choice === 'retro') {
                    filters.push(new fabric.Image.filters.Vintage());
                }
                img.filters = filters;
                img.applyFilters();
            });
        }

        // Add text at bottom canvas
        function addJepretkuText() {
            let text = 'Jepretku'
            const caption = new fabric.Text(text, {
                left: canvas.getWidth() - padding,
                top: (height / 3.3) * 3 + padding,
                originX: 'right',
                textAlign: 'right',
                fontSize: 20,
                fill: '#000',
                selectable: false,
                evented: false
            });
            canvas.add(caption);
        }

        // --- SAVE TO JPG ---
        saveButton.addEventListener('click', () => {
            const multiplier = 1920 / canvas.getHeight();
            const dataURL = canvas.toDataURL({
                format: 'jpeg',
                quality: 1,
                multiplier: multiplier
            });

            fetch('/snapshots', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        title: 'Jepretku Snapshot',
                        image: dataURL
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alert('Snapshot saved successfully!');
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        });
    </script>
</x-app-layout>
