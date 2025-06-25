<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Photobooth') }}
        </h2>
    </x-slot>

    <style>
        #canvas {
            border: 1px solid #999;
            width: 270px;
            height: 660px;
        }

        .controls-container>div {
            margin: 10px 0;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col">
                        <div class="flex flex-row flex-wrap justify-center items-center controls-container">
                            <div class="flex-1 flex justify-center items-center min-w-[200px]">
                                <label for="timerSelect">Timer : </label>
                                <select id="timerSelect" class="ml-2">
                                    <option value="0">0s</option>
                                    <option value="3">3s</option>
                                    <option value="5">5s</option>
                                    <option value="10">10s</option>
                                </select>
                            </div>

                            <div class="flex-1 flex justify-center items-center min-w-[200px]">
                                <label for="layoutSelect">Layout : </label>
                                <select id="layoutSelect" class="ml-2">
                                </select>
                            </div>

                            <div class="flex-1 flex justify-center items-center min-w-[200px]">
                                <label for="filterSelect">Filter : </label>
                                <select id="filterSelect" class="ml-2">
                                    <option value="none">None</option>
                                    <option value="grayscale">Grayscale</option>
                                    <option value="sepia">Sepia</option>
                                    <option value="retro">Retro</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-row flex-wrap flex-1 justify-center items-center mt-4">
                            <div class="flex gap-4">
                                <div class="flex flex-col gap-4 items-center">
                                    <div style="position: relative; width:600px; height:450px;">
                                        <video id="video" autoplay playsinline
                                            style="border:1px solid#999; width:100%; height:100%; object-fit: cover;">
                                        </video>
                                        <div id="countdownDisplay"
                                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 100px; color: white; text-shadow: 2px 2px 8px rgba(0,0,0,0.7); display: none;">
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <button id="captureBtn"
                                            class="px-6 py-3 mx-2 bg-green-500 hover:bg-green-700 rounded-lg text-white font-semibold">
                                            Capture
                                        </button>

                                        <button id="retakeBtn"
                                            class="px-6 py-3 mx-2 bg-yellow-500 hover:bg-orange-400 rounded-lg text-white font-semibold">
                                            Retake
                                        </button>
                                        <button id="nextBtn"
                                            class="px-6 py-3 mx-2 bg-red-400 hover:bg-orange-600 rounded-lg text-white font-semibold">
                                            Next
                                        </button>
                                        <button id="saveBtn"
                                            class="px-6 py-3 mx-2 bg-red-400 hover:bg-orange-600 rounded-lg text-white font-semibold">
                                            Save Snapshot
                                        </button>
                                    </div>
                                </div>
                                <canvas id="canvas" width="270" height="660"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>
    <script>
        const smallPadding = 10;
        const mediumPadding = 20;

        const layouts = {
            "classic_strip_3": {
                name: "Classic Strip (3 Pose)",
                canvas: {
                    width: 270,
                    height: 660
                },
                poses: 3,
                photos: [{
                        x: smallPadding,
                        y: smallPadding,
                        width: 250,
                        height: 187.5
                    },
                    {
                        x: smallPadding,
                        y: 207.5,
                        width: 250,
                        height: 187.5
                    },
                    {
                        x: smallPadding,
                        y: 405,
                        width: 250,
                        height: 187.5
                    }
                ],
                design: {
                    background: '#ffffff',
                    texts: [{
                        content: 'Jepretku',
                        left: 260,
                        top: 615,
                        fontSize: 20,
                        fill: '#000',
                        originX: 'right'
                    }]
                }
            },
            "classic_strip_6": {
                name: "Classic Strip (6 Pose)",
                canvas: {
                    width: 530,
                    height: 660
                },
                poses: 6,
                photos: [{
                        x: smallPadding,
                        y: smallPadding,
                        width: 250,
                        height: 187.5
                    },
                    {
                        x: 2 * smallPadding + 250,
                        y: smallPadding,
                        width: 250,
                        height: 187.5
                    },
                    {
                        x: smallPadding,
                        y: 207.5,
                        width: 250,
                        height: 187.5
                    },
                    {
                        x: 2 * smallPadding + 250,
                        y: 207.5,
                        width: 250,
                        height: 187.5
                    },
                    {
                        x: smallPadding,
                        y: 405,
                        width: 250,
                        height: 187.5
                    },
                    {
                        x: 2 * smallPadding + 250,
                        y: 405,
                        width: 250,
                        height: 187.5
                    },
                ],
                design: {
                    background: '#ffffff',
                    texts: [{
                        content: 'Jepretku',
                        left: 520,
                        top: 615,
                        fontSize: 20,
                        fill: '#000',
                        originX: 'right'
                    }]
                }
            },
        };

        let capturedImages = [];
        let step = 0;
        let state = 'capture';
        let timerInterval = null;
        let currentLayoutId = Object.keys(layouts)[0];

        const captureButton = document.getElementById('captureBtn');
        const retakeButton = document.getElementById('retakeBtn');
        const nextButton = document.getElementById('nextBtn');
        const saveButton = document.getElementById('saveBtn');
        const timerSelect = document.getElementById('timerSelect');
        const filterSelect = document.getElementById('filterSelect');
        const layoutSelect = document.getElementById('layoutSelect');
        const countdownDisplay = document.getElementById('countdownDisplay');
        const video = document.getElementById('video');
        const canvasElement = document.getElementById('canvas');

        const canvas = new fabric.Canvas('canvas', {
            selection: false
        });

        document.addEventListener('DOMContentLoaded', () => {
            for (const id in layouts) {
                const option = document.createElement('option');
                option.value = id;
                option.innerText = layouts[id].name;
                layoutSelect.appendChild(option);
            }

            initializeLayout();

            layoutSelect.addEventListener('change', (e) => {
                currentLayoutId = e.target.value;
                initializeLayout();
            });

            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(stream => video.srcObject = stream)
                .catch(err => alert('Camera error: ' + err));
        });


        function initializeLayout() {
            const config = layouts[currentLayoutId];

            canvas.backgroundColor = config.design.background;

            resizeCanvas(config.canvas.width, config.canvas.height);

            capturedImages = [];
            step = 0;
            state = 'capture';

            applyButtonState();
            stackAndRender();
        }


        function resizeCanvas(newWidth, newHeight) {
            canvasElement.width = newWidth;
            canvasElement.height = newHeight;
            canvasElement.style.width = newWidth + 'px';
            canvasElement.style.height = newHeight + 'px';
            canvas.setWidth(newWidth);
            canvas.setHeight(newHeight);
        }


        function performCapture() {
            const config = layouts[currentLayoutId];
            if (step >= config.poses) return;

            const photoConfig = config.photos[step];

            const tmp = document.createElement('canvas');
            tmp.width = video.videoWidth;
            tmp.height = video.videoHeight;
            tmp.getContext('2d').drawImage(video, 0, 0);

            const dataURL = tmp.toDataURL();
            fabric.Image.fromURL(dataURL, img => {
                const scaleX = photoConfig.width / img.width;
                const scaleY = photoConfig.height / img.height;

                img.set({
                    scaleX,
                    scaleY,
                    selectable: false,
                    evented: false
                });

                capturedImages[step] = img;
                stackAndRender();
                changeState('evaluate');
            });
        }


        function stackAndRender() {
            const config = layouts[currentLayoutId];

            canvas.clear();
            canvas.backgroundColor = config.design.background;

            capturedImages.forEach((img, index) => {
                const photoConfig = config.photos[index];
                img.set({
                    left: photoConfig.x,
                    top: photoConfig.y,
                    originX: 'left',
                    originY: 'top'
                });
                canvas.add(img);
            });

            if (config.design.texts) {
                config.design.texts.forEach(textInfo => {
                    const text = new fabric.Text(textInfo.content, {
                        ...textInfo,
                        selectable: false,
                        evented: false
                    });
                    canvas.add(text);
                });
            }

            applyFilterToAll();
            canvas.requestRenderAll();
        }


        captureButton.addEventListener('click', () => {
            const selectedTime = parseInt(timerSelect.value, 10);
            if (selectedTime === 0) {
                performCapture();
            } else {
                startTimer(selectedTime);
            }
        });


        function startTimer(duration) {
            captureButton.disabled = true;
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
                }
            }, 1000);
        }


        retakeButton.addEventListener('click', () => changeState('capture'));
        nextButton.addEventListener('click', () => {
            step++;
            changeState('capture');
        });


        function changeState(newState) {
            state = newState;
            applyButtonState();
        }


        function applyButtonState() {
            const config = layouts[currentLayoutId];
            captureButton.hidden = (state === 'evaluate' || step >= config.poses);
            retakeButton.hidden = (state === 'capture');
            nextButton.hidden = (state === 'capture' || step >= config.poses - 1);
            saveButton.hidden = (state === 'capture' || step < config.poses - 1);
        }


        filterSelect.addEventListener('change', () => {
            applyFilterToAll();
            canvas.requestRenderAll();
        });


        function applyFilterToAll() {
            const choice = filterSelect.value;
            capturedImages.forEach(img => {
                let filters = [];
                if (choice === 'grayscale') filters.push(new fabric.Image.filters.Grayscale());
                if (choice === 'sepia') filters.push(new fabric.Image.filters.Sepia());
                if (choice === 'retro') filters.push(new fabric.Image.filters.Vintage());
                img.filters = filters;
                img.applyFilters();
            });
        }


        saveButton.addEventListener('click', () => {
            const multiplier = 1920 / canvas.getHeight();
            const dataURL = canvas.toDataURL({
                format: 'jpeg',
                quality: 1,
                multiplier
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
                .then(data => alert('Snapshot saved successfully!'))
                .catch((error) => console.error('Error:', error));
        });
    </script>
</x-app-layout>
