@extends('app')

@section('content')
    <div class="content">
        <input type="hidden" class="_evt-id" value="{{ $id }}">
        <div class="flex flex-col">
            <h2>Modifica</h2>
            <div class="custom-form">
                <label class="styled-label">
                    <small>Titolo</small>
                    <input class="_evt-feed-post-title" type="text">
                </label>
                <label class="styled-label">
                    <small>Post Content</small>
                    <select class="_evt-feed-post-text"></select>
                </label>

            </div>
            <div class="flex w-full justify-end mt-4">
                <button class="_evt-save">Salva</button>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            /************************************************************************************
             * VARIABLES
             */
            let feedPostId = $('._evt-id').val();
            let $feedPostTitle = $('._evt-feed-post-title');
            let $feedPostText = $('._evt-feed-post-text');
            let $saveButton = $('._evt-save');
            /************************************************************************************
             * ENTRY POINT
             */
            _fetchData();
            /************************************************************************************
             * SELECTORS
             */
            $saveButton.click(function () {
                _update();
            })
            /************************************************************************************
             * FUNCTIONS
             */
            /**
             * @desc Fetch feed posts
             * @private
             */
            function _fetchData() {
                // Get feed posts
                $.ajax({
                    url: `http://localhost:80/api/v1/feed-posts/${feedPostId}?with=text`,
                    method: 'GET',
                    headers: {
                        "Accept": "application/json",
                        "Content-type": "application/json",
                        "Authorization": `Bearer ${window.localStorage.getItem('access_token')}`,
                    },
                    success: function (response) {
                        // Check if has data
                        if (response.hasOwnProperty('data')) {
                            // Set data
                            $feedPostTitle.val(response.data.title)
                            $feedPostText.val(response.data.text)

                            _fetchSectors(response.data.text.id)
                        }
                    },
                    error: function (error) {
                        console.error(error)
                    }
                });
            }
            /**
             * @desc Fetch feed posts and set the correct one selected
             * @param selected_text_id
             * @private
             */
            function _fetchSectors(selected_text_id) {
                // Get feed posts
                $.ajax({
                    url: `http://localhost:80/api/v1/posts`,
                    method: 'GET',
                    headers: {
                        "Accept": "application/json",
                        "Content-type": "application/json",
                        "Authorization": `Bearer ${window.localStorage.getItem('access_token')}`,
                    },
                    success: function (response) {
                        // Check if has data
                        if (response.hasOwnProperty('data')) {
                            response.data.forEach(function (item) {
                                if (item.id === selected_text_id) {
                                    $feedPostText.append(`<option selected value="${item.id}">${item.name}</option>`)
                                } else {
                                    $feedPostText.append(`<option value="${item.id}">${item.name}</option>`)
                                }
                            })
                        }
                    },
                    error: function (error) {
                        console.error(error)
                    }
                });
            }
            /**
             * @desc Update feed post
             * @private
             */
            function _update() {
                $.ajax({
                    url: `http://localhost:80/api/v1/feed-posts/${feedPostId}`,
                    method: 'PUT',
                    headers: {
                        "Accept": "application/json",
                        "Content-type": "application/json",
                        "Authorization": `Bearer ${window.localStorage.getItem('access_token')}`,
                    },
                    data: JSON.stringify({
                        title: $feedPostTitle.val(),
                        text: $feedPostText.val(),

                    }),
                    success: function (response) {
                        window.location.href = "/feed-posts";
                    },
                    error: function (error) {
                        console.error(error)
                    }
                });
            }
        });
    </script>
@endsection
