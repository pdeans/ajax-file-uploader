var app = app || {};

(function(o) {
    "use strict";

    // Private methods
    var ajax, getFormData, setProgress;

    ajax = function(data) {
        var xmlhttp = new XMLHttpRequest(), uploaded;

        // Check ready-state
        xmlhttp.addEventListener('readystatechange', function() {
            if(this.readyState === 4) {
                if(this.status === 200) {
                    uploaded = JSON.parse(this.response);

                    if(typeof o.options.finished === 'function') {
                        o.options.finished(uploaded);
                    }
                } else {
                    if(typeof o.options.error === 'function') {
                        o.options.error();
                    }
                }
            }
        });

        // Set Progress Bar listener
        xmlhttp.upload.addEventListener('progress', function(event) {
            var percent;

            if(event.lengthComputable === true) {
                percent = Math.round(event.loaded / event.total * 100);
                setProgress(percent);
            }
        });

        xmlhttp.open('post', o.options.processor);
        xmlhttp.send(data);
    };

    getFormData = function(source) {
        var data = new FormData(), i;

        // Loop through files and add to data object
        for(i = 0; i < source.length; i++) {
            data.append('file[]', source[i]);
        }

        // Set $_POST['ajax'] to true
        data.append('ajax', true);

        return data;
    };

    setProgress = function(value) {
        var percentage = value + '%';

        if(o.options.progressBar !== undefined) {
            o.options.progressBar.style.width = value ? percentage : 0;
        }

        if(o.options.progressText !== undefined) {
            o.options.progressText.innerText = value ? percentage : '';
        }
    };

    o.uploader = function(options) {
        o.options = options;

        // Get form data
        if(o.options.files !== undefined) {
            ajax(getFormData(o.options.files.files));
        }
    };
}(app));
