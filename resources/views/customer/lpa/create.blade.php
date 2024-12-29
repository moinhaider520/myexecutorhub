@extends('layouts.master')

@section('content')
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

<script>
  const startButton = document.getElementById("start-button");
  const canvasContainer = document.getElementById("canvas-container");
  const videoCanvas = document.getElementById("video-canvas");
  const previewVideo = document.getElementById("preview-video");
  const repeatButton = document.getElementById("repeat-button");
  const nextButton = document.getElementById("next-button");
  const saveButton = document.getElementById("save-button");

  const canvasContext = videoCanvas.getContext("2d");
  const dummyVideos = Array.from({ length: 45 }, (_, i) => `{{ asset('assets/lpa_videos/video') }}` + (i + 1) + `.mp4`);

  let currentVideoIndex = 0;
  let webcamStream;
  let recorder;
  let recordedChunks = [];


  async function startWebcam() {
    try {
      const constraints = {
        video: {
          width: { ideal: 1280 }, // Higher resolution for better quality
          height: { ideal: 720 }, // Higher resolution for better quality
          facingMode: 'user', // Front-facing camera
        },
        audio: true // Include audio from the microphone
      };

      // Request access to webcam and microphone
      webcamStream = await navigator.mediaDevices.getUserMedia(constraints);

      // Create a video element to play the webcam feed
      const webcamVideoElement = document.createElement("video");
      webcamVideoElement.srcObject = webcamStream;
      webcamVideoElement.play();

      // Extract the microphone audio track
      const micAudioTrack = webcamStream.getAudioTracks()[0];

      // Play the preview video and extract its audio
      previewVideo.src = dummyVideos[currentVideoIndex];
      previewVideo.play();

      // Use AudioContext to combine audio streams
      const audioContext = new AudioContext();

      // Microphone audio source
      const micSource = audioContext.createMediaStreamSource(new MediaStream([micAudioTrack]));

      // Browser (preview video) audio source
      const previewAudioSource = audioContext.createMediaElementSource(previewVideo);

      // Destination for combined audio
      const combinedAudioDestination = audioContext.createMediaStreamDestination();

      // Connect audio sources
      micSource.connect(combinedAudioDestination);
      previewAudioSource.connect(combinedAudioDestination);
      previewAudioSource.connect(audioContext.destination); // For live preview audio

      // Capture the canvas video stream
      const canvasStream = videoCanvas.captureStream();

      // Combine video from canvas and audio
      const combinedStream = new MediaStream([
        canvasStream.getVideoTracks()[0],
        ...combinedAudioDestination.stream.getAudioTracks()
      ]);

      // Adjust the canvas resolution to match the webcam feed
      const { width, height } = webcamStream.getVideoTracks()[0].getSettings();
      videoCanvas.width = width;
      videoCanvas.height = height;

      // Draw webcam and preview video on the canvas
      webcamVideoElement.addEventListener("play", () => {
        function draw() {
          // Draw webcam feed at full resolution
          canvasContext.drawImage(webcamVideoElement, 0, 0, videoCanvas.width, videoCanvas.height);

          // Draw preview video in the corner with improved quality
          if (!previewVideo.paused && !previewVideo.ended) {
            canvasContext.drawImage(
              previewVideo,
              0, // X-coordinate
              0, // Y-coordinate
              320, // Preview video width
              180 // Preview video height
            );
          }

          // Repeat drawing for live animation
          requestAnimationFrame(draw);
        }

        draw();
      });

      // Create MediaRecorder for recording combined stream
      recorder = new MediaRecorder(combinedStream);
      recorder.ondataavailable = (event) => recordedChunks.push(event.data);
      recorder.start();

    } catch (err) {
      alert("Error accessing webcam or microphone. Please check permissions.");
      location.reload();
    }
  }



  function playPreviewVideo() {
    previewVideo.src = dummyVideos[currentVideoIndex];
    previewVideo.play();
    repeatButton.style.display = "none"; // Hide repeat button when new video starts
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
    if (currentVideoIndex < dummyVideos.length) {
      playPreviewVideo();
    }

    if (currentVideoIndex === dummyVideos.length - 1) {
      nextButton.style.display = "none";
      saveButton.style.display = "block";
    }
  });

  saveButton.addEventListener("click", () => {
    recorder.stop();
    recorder.onstop = async () => {
      const authId = "{{ $authId }}";
      const blob = new Blob(recordedChunks, { type: "video/mp4" });
      const formData = new FormData();
      formData.append("video", blob);
      formData.append("auth_id", authId); // Replace with actual auth ID if available.

      try {
        const response = await fetch("/lpa/store", {
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
          },
          body: formData,
        });

        if (response.ok) {
          const data = await response.json();
          alert("Video uploaded successfully!");
          console.log("Cloudinary URL:", data.url);
        } else {
          alert("Video upload failed!");
        }
      } catch (err) {
        console.error("Error uploading video:", err);
      }
    };
  });

  previewVideo.addEventListener("ended", () => {
    repeatButton.style.display = "inline-block";
  });
</script>
@endsection