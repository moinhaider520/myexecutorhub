@extends('layouts.master')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
  #dummy-text {
    margin-bottom: 20px;
    font-size: 18px;
  }

  canvas,
  video {
    border: 1px solid #ddd;
    background-color: #000;
  }

  .canvas-container {
    position: relative;
    display: none;
  }

  canvas {
    width: 640px;
    height: 360px;
  }

  video.preview {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 150px;
    height: 90px;
    display: none;
  }

  .controls {
    display: flex;
    justify-content: space-between;
    width: 640px;
    margin-top: 10px;
  }
</style>

<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>LPA Video</h4>
              </div>
              <div class="card-body">
                <div id="dummy-text"><b>You are ready to start.</b>It should take 10-20 minutes. You must complete your
                  session in one go. If you pause or cancel your session you will have to start again from Device Check.
                </div>
                <button id="start-button" class="btn btn-primary">Start</button>

                <div class="canvas-container" id="canvas-container">
                  <canvas id="video-canvas"></canvas>
                  <video class="preview" id="preview-video" autoplay></video>

                  <div class="controls">
                    <button id="repeat-button" style="display: none;" class="btn btn-secondary">Repeat Video</button>
                    <button id="next-button" class="btn btn-primary">Next</button>
                    <button id="save-button" class="btn btn-primary" style="display: none;">Save Recording</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid Ends-->
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
  const startButton = document.getElementById("start-button");
  const canvasContainer = document.getElementById("canvas-container");
  const videoCanvas = document.getElementById("video-canvas");
  const previewVideo = document.getElementById("preview-video");
  const repeatButton = document.getElementById("repeat-button");
  const nextButton = document.getElementById("next-button");
  const saveButton = document.getElementById("save-button");

  const canvasContext = videoCanvas.getContext("2d");

  // Define the number of videos and a function to get video URLs lazily
  const totalVideos = 23;
  const getVideoUrl = (index) => `{{ asset('assets/lpa_videos/video') }}` + (index + 1) + `.mp4`;
  let currentVideoIndex = 0;
  let webcamStream;
  let recorder;
  let recordedChunks = [];

  async function startWebcam() {
    try {
      const constraints = {
        video: {
          width: { ideal: 1280 },
          height: { ideal: 720 },
          facingMode: "user",
        },
        audio: true,
      };

      webcamStream = await navigator.mediaDevices.getUserMedia(constraints);

      const webcamVideoElement = document.createElement("video");
      webcamVideoElement.srcObject = webcamStream;
      webcamVideoElement.play();

      const micAudioTrack = webcamStream.getAudioTracks()[0];

      previewVideo.src = getVideoUrl(currentVideoIndex); // Load the first video lazily
      previewVideo.load();
      previewVideo.play();

      const audioContext = new AudioContext();
      const micSource = audioContext.createMediaStreamSource(new MediaStream([micAudioTrack]));
      const previewAudioSource = audioContext.createMediaElementSource(previewVideo);
      const combinedAudioDestination = audioContext.createMediaStreamDestination();

      micSource.connect(combinedAudioDestination);
      previewAudioSource.connect(combinedAudioDestination);
      previewAudioSource.connect(audioContext.destination);

      const canvasStream = videoCanvas.captureStream();
      const combinedStream = new MediaStream([
        canvasStream.getVideoTracks()[0],
        ...combinedAudioDestination.stream.getAudioTracks(),
      ]);

      const { width, height } = webcamStream.getVideoTracks()[0].getSettings();
      videoCanvas.width = width;
      videoCanvas.height = height;

      webcamVideoElement.addEventListener("play", () => {
        function draw() {
          canvasContext.drawImage(webcamVideoElement, 0, 0, videoCanvas.width, videoCanvas.height);

          if (!previewVideo.paused && !previewVideo.ended) {
            canvasContext.drawImage(previewVideo, 0, 0, 320, 180);
          }

          requestAnimationFrame(draw);
        }

        draw();
      });

      recorder = new MediaRecorder(combinedStream);
      recorder.ondataavailable = (event) => recordedChunks.push(event.data);
      recorder.start();
    } catch (err) {
      alert("Error accessing webcam or microphone. Please check permissions.");
      location.reload();
    }
  }

  function playPreviewVideo() {
    previewVideo.src = getVideoUrl(currentVideoIndex); // Load the video lazily
    previewVideo.load();
    previewVideo.play();
    repeatButton.style.display = "none";
  }

  startButton.addEventListener("click", () => {
    document.getElementById("dummy-text").style.display = "none";
    startButton.style.display = "none";
    canvasContainer.style.display = "block";

    startWebcam();
    playPreviewVideo();
  });

  repeatButton.addEventListener("click", () => {
    playPreviewVideo();
  });

  nextButton.addEventListener("click", () => {
    currentVideoIndex++;
    if (currentVideoIndex < totalVideos) {
      playPreviewVideo();
    }

    if (currentVideoIndex === totalVideos - 1) {
      nextButton.style.display = "none";
      saveButton.style.display = "block";
    }
  });

  saveButton.addEventListener("click", () => {
    recorder.stop();

    recorder.onstop = () => {
      if (webcamStream) {
        webcamStream.getTracks().forEach((track) => track.stop());
      }

      const authId = "{{ $authId }}";
      const blob = new Blob(recordedChunks, { type: "video/mp4" });
      console.log(blob);
      const formData = new FormData();
      formData.append("video", blob, "recorded-video.mp4");
      formData.append("auth_id", authId);

      const swalInstance = Swal.fire({
        title: "Uploading...",
        text: "Please wait while your video is being uploaded.",
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        },
        onBeforeOpen: () => {
          swalInstance.text = "Uploading... 0%";
        }
      });

      // AJAX request to upload the video
      $.ajax({
        url: "/partner/lpa/store",
        type: "POST",
        headers: {
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        },
        data: formData,
        processData: false,
        contentType: false,
        xhr: function () {
          const xhr = new XMLHttpRequest();
          xhr.upload.addEventListener("progress", function (e) {
            if (e.lengthComputable) {
              const percent = Math.round((e.loaded / e.total) * 100);
              swalInstance.text = `Uploading... ${percent}%`;
              console.log(percent);
            }
          });
          return xhr;
        },
        success: function () {
          Swal.fire({
            icon: "success",
            title: "Upload Successful",
            text: "Your video has been uploaded successfully.",
          });
          location.reload();
        },
        error: function (xhr, status, error) {
          Swal.fire({
            icon: "error",
            title: "Upload Failed",
            text: "There was an error uploading your video. Please try again.",
          });
          console.error("Video upload failed:", status, error);
        },
      });
    };
  });

  previewVideo.addEventListener("ended", () => {
    repeatButton.style.display = "inline-block";
  });
</script>



@endsection