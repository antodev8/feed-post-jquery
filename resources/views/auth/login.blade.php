@extends('app')

@section('content')

<div class="content">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col">
        <div class="mb-4">
            <label class="block text-grey-darker text-sm font-bold mb-2" for="username">
                Email
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="email"
                   type="text" value="admin@admin.it" placeholder="Email">
        </div>
        <div class="mb-6">
            <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                Password
            </label>
            <input class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3"
                   id="password" value="password" type="password" placeholder="******************">
            <p class="text-red text-xs italic">Please choose a password.</p>
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded _evt-button-login"
                    type="button">
                Log in
            </button>
        </div>
    </div>
</div>
    <script>
        // Aspetto che la pagina ( e tutti gli elementi ) sia renderizzata
        $(document).ready(function () {
            // Get access token from storage
            const access_token = window.localStorage.getItem('access_token')
            // Check if user is logged and token is valid
            if (access_token) {
                $.ajax({
                    url: 'http://localhost:80/api/v1/user',
                    method: 'GET',
                    headers: {
                        "Accept": "application/json",
                        "Content-type": "application/json",
                        "Authorization": `Bearer ${access_token}`,
                    },
                    success: function (response) {
                        // Check if has data
                        if (response.hasOwnProperty('data')) {
                            window.location = "feed-posts";
                        }
                    },
                    error: function (error) {
                        window.localStorage.removeItem('access_token')
                    }
                });
            }
            // Attach login button event
            $("._evt-button-login").click(function () {
                let email = $("#email").val().trim();
                let password = $("#password").val().trim();
                let dataObject = {
                    email: email,
                    password: password
                };
                if (email !== "" && password !== "") {
                    $.ajax({
                        url: 'http://localhost:80/api/v1/login',
                        method: 'POST',
                        headers: {
                            "Accept": "application/json",
                            "Content-type": "application/json",
                        },
                        data: JSON.stringify(dataObject),
                        success: function (response) {
                            // Check if has data
                            if (response.hasOwnProperty('data')) {
                                window.localStorage.setItem('access_token', response.data.access_token)
                                window.location = "feed-posts";
                            }
                        },
                        error: function (error) {
                            console.error(error)
                        }
                    });
                }
            });
        });
    </script>
@endsection
