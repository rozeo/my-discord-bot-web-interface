@extends('layout.base')

@section('main')
    <form action="{{ $actionUri }}" class="form" method="POST" id="form">
        <div class="form-group">
            <input type="file" multiple id="file-input" style="display: none">
            <button type="button" class="form-control btn btn-info" id="file-input-fake">
                ファイルを選択(複数)
            </button>
        </div>
    </form>

    <ul class="list-group" id="upload-queues">
    </ul>

    <div style="display: none" id="list-temp">
        <div style="display: flex; justify-content: space-between" class="mb-2">
            <span class="filename">Filename</span>
            <span class="progress-status">0 %</span>
        </div>

        <div class="progress" style="height: 4px;">
            <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="upload-message mt-2 text-right" style="color: #888">
        </div>
    </div>

@endsection

@section('script')
    <script>

        let uploadFileStack = []
        let currentFile = null
        let currentIndex = 0

        let uploadProcess = () => {
            if (currentFile) {
                return false;
            }

            currentFile = uploadFileStack.pop()
            console.log(currentFile)
            if (!currentFile) {
                return false;
            }

            let params = new FormData()
            params.append('file', currentFile['file'])

            let config = {
                onUploadProgress: (ev) => {
                    let index = currentFile['index']
                    let el = document.getElementById('file-' + index)

                    let progress = Math.floor( ev.loaded / ev.total * 100)

                    el.querySelector('.progress-status').innerText = progress + " %";
                    el.querySelector('.progress-bar').style.width = progress + "%";
                }
            }

            axios.post(
                document.getElementById('form').getAttribute('action'),
                params,
                config
            ).then((prom) => {
                let index = currentFile['index']
                let el = document.getElementById('file-' + index)

                el.querySelector('.progress-status').innerText = "Done!";
                el.querySelector('.progress-bar').classList.add('bg-success');

                setTimeout(() => { el.parentNode.removeChild(el)}, 3000);
            }).catch((prom) => {
                console.log(prom)

                let index = currentFile['index']
                let el = document.getElementById('file-' + index)
                console.log(prom)

                el.querySelector('.progress-status').innerText = "Error!";
                el.querySelector('.progress-bar').classList.add('bg-danger');
                el.querySelector('.upload-message').innerText = prom.response.data.message;
            }).finally(() => {
                let index = currentFile['index']
                let el = document.getElementById('file-' + index)

                currentFile = null
                uploadProcess()
            })
        }

        let uploadDispatch = (files) => {
            for (let i = 0; i < files.length; i++) {
                uploadFileStack.push({
                    'index': currentIndex,
                    'file': files[i]
                })

                let el = document.createElement('li')
                el.innerHTML = document.getElementById('list-temp').innerHTML
                el.classList.add('list-group-item')
                el.style.display = ''

                el.querySelector('.filename').innerText = files[i].name

                el.id = 'file-' + currentIndex

                document.getElementById('upload-queues').appendChild(el)

                currentIndex++
            }
            uploadProcess()
        }

        window.addEventListener('load', () => {
            document.getElementById('file-input-fake').addEventListener('click', () => {
                document.getElementById('file-input').click();
            });

            document.getElementById('file-input').addEventListener('change', function () {
                uploadDispatch(this.files);
                this.value = '';
            });
        });
    </script>
@endsection
