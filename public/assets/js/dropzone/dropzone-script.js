/**=====================
    Custom Dropzone  Start
==========================**/
(function() {
    var DropzoneExample = (function() {
        var DropzoneDemos = function() {
            Dropzone.options.singleFileUpload = {
                paramName: "file",
                maxFiles: 1,
                maxFilesize: 5,
                addRemoveLinks: true,
                accept: function(file, done) {
                    if (file.name == "justinbieber.jpg") {
                        done("Naha, you don't.");
                    } else {
                        done();
                    }
                },
            };
            Dropzone.options.multiFileUpload = {
                paramName: "file",
                maxFiles: 10,
                maxFilesize: 10,
                addRemoveLinks: true,
                accept: function(file, done) {
                    if (file.name == "justinbieber.jpg") {
                        done("Naha, you don't.");
                    } else {
                        done();
                    }
                },
            };
            Dropzone.options.fileTypeValidation = {
                paramName: "file",
                maxFiles: 10,
                maxFilesize: 10,
                addRemoveLinks: true,
                acceptedFiles: "image/*,application/pdf,.psd",
                accept: function(file, done) {
                    if (file.name == "justinbieber.jpg") {
                        done("Naha, you don't.");
                    } else {
                        done();
                    }
                },
            };
        };
        return {
            init: function() {
                DropzoneDemos();
            },
        };
    })();
    DropzoneExample.init();
})();

/**=====================
    Custom Dropzone Ends
==========================**/