@extends('app')

@section('content')
    <div class="content">
        <h3>Feed Post</h3>
        <div class="flex flex-col">


            <button >
                <a href="{{route('posts.create')}}" class="_evt-create-post-selected pointer-events-none opacity-50 mr-4">Crea Post</a>

            </button>
            <label class="styled-label">

                <input class="_evt-text-search" type="text">
            </label>

            <div class="feed-actions">
                <label class="styled-label">
                    <small>Per pagina</small>
                    <select class="_evt-per-page">
                        <option selected value="5">5</option>
                        <option value="15">15</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </label>
                <div class="flex flex-row items-end">

                </div>
            </div>
        </div>
        <table id="feed-posts-table">
            <thead>

                <th scope="col"><input class="_evt-select-all" type="checkbox"><button class="_evt-delete-selected pointer-events-none opacity-50 mr-5">Elimina selezionati
                </button></th>


                <tr>
                <th scope="col">Title</th>



                <th scope="col">Post Content</th>

            </tr>
            </thead>
            <tbody class="_evt-feed-posts-list">

            </tbody>


        </table>















        <div class="_evt-spinner loader">Loading...</div>
        <ul class="_evt-feed-posts-pagination pagination-container"></ul>
    </div>
    <script>
        $(document).ready(function () {
            /************************************************************************************
             * VARIABLES
             */
            let typingTimer;
            let doneTypingInterval = 300;
            let $textSearchInput = $('._evt-text-search');
            let $perPageSelect = $('._evt-per-page');
            let $paginationContainer = $('._evt-feed-posts-pagination');
            let $spinner = $('._evt-spinner');
            let $checkboxSelectAll = $('._evt-select-all');
            let $tableTbody = $('#feed-posts-table tbody');
            let $buttonDeleteSelected = $('._evt-delete-selected');
            let currentPage = 1
            let selectedIds = []
            /************************************************************************************
             * ENTRY POINT
             */
            _fetchData();
            /************************************************************************************
             * SELECTORS
             */
            $textSearchInput.on('keyup', function () {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(_fetchData, doneTypingInterval);
            });
            $textSearchInput.on('keydown', function () {
                clearTimeout(typingTimer);
            });
            $perPageSelect.on('change', function () {
                _fetchData()
            })
            // On page click
            $paginationContainer.on('click', '._evt-pagination-button', function () {
                // Set current page
                if (currentPage !== $(this).data('page')) {
                    currentPage = $(this).data('page')
                    // Fetch new data
                    _fetchData()
                }
            });
            // Destroy feed post
            $tableTbody.on('click', '._evt-destroy-feed-post', function () {
                // Get id from data
                let id = $(this).data("id");
                // Check if has id
                if (!id) {
                    alert('ID non valido');
                }
                _destroy(id)
            });
            // On change checkbox inside table
            $tableTbody.on('change', 'input[type="checkbox"]', function () {
                // If checkbox is not checked
                if (!this.checked) {
                    // Get the element
                    let el = $checkboxSelectAll.get(0);
                    // If "Select all" control is checked and has 'indeterminate' property
                    if (el && el.checked && ('indeterminate' in el)) {
                        // Set visual state of "Select all" control
                        // as 'indeterminate'
                        el.indeterminate = true;
                    }
                }
                // Iterate over all checkboxes in the table for check if at least one is checked
                $('#feed-posts-table tbody input[type="checkbox"]').each(function () {
                    // Check if at least one checkbox is checked
                    if (this.checked) {
                        $buttonDeleteSelected.removeClass('pointer-events-none opacity-50');
                        return false
                    } else {
                        $buttonDeleteSelected.addClass('pointer-events-none opacity-50');
                    }
                });
            });
            // Handle click on "Select all" control
            $checkboxSelectAll.on('click', function () {
                let isChecked = this.checked
                // Check/uncheck all checkboxes in the table
                $('#feed-posts-table tbody input[type="checkbox"]').each(function () {
                    this.checked = isChecked
                })
                if (this.checked) {
                    $buttonDeleteSelected.removeClass('pointer-events-none opacity-50');
                } else {
                    $buttonDeleteSelected.addClass('pointer-events-none opacity-50');
                }
            });
            // Bulk delete elements
            $buttonDeleteSelected.on('click', function () {
                let ids = []
                // Check/uncheck all checkboxes in the table
                $('#feed-posts-table tbody input[type="checkbox"]').each(function () {
                    if (this.checked) {
                        ids.push(this.value)
                    }
                })
                // Fare la bulk delete
                console.log(ids);
            })
            /************************************************************************************
             * FUNCTIONS
             */
            /**
             * @desc Fetch feed posts
             * @private
             */
            function _fetchData() {
                $tableTbody.empty()
                $spinner.show()
                $checkboxSelectAll.prop('checked', false)
                $buttonDeleteSelected.removeClass('pointer-events-none opacity-50');
                $buttonDeleteSelected.addClass('pointer-events-none opacity-50');
                // Get feed posts
                $.ajax({
                    url: 'http://localhost:80/api/v1/feed-posts',
                    method: 'GET',
                    headers: {
                        "Accept": "application/json",
                        "Content-type": "application/json",
                        "Authorization": `Bearer ${window.localStorage.getItem('access_token')}`,
                    },
                    data: {
                        text: $textSearchInput.val(),
                        page: currentPage,
                        per_page: $perPageSelect.val()
                    },
                    success: function (response) {
                        // Check if has data
                        if (response.hasOwnProperty('data')) {
                            response.data.forEach(function (item) {
                                $('._evt-feed-posts-list').append(`<tr>
<td><input type="checkbox" value="${item.id}"></td>
<td>${item.title}</td>
<td>${item.text}</td>
<td>
<a href='/feed-posts/${item.id}/edit' class="_evt-edit-feed-post">Modifica</a>
<button data-id="${item.id}" class="_evt-destroy-feed-post">Elimina</button>
</td>
</tr>`)
                            })
                            $spinner.hide()
                            generatePagination(response.meta)
                        }
                    },
                    error: function (error) {
                        $spinner.hide()
                        console.error(error)
                    }
                });
            }
            /**
             * @desc Destroy feed post
             * @private
             */
            function _destroy(id) {
                // Destroy element
                $.ajax({
                    url: `http://localhost:80/api/v1/feed-posts/${id}`,
                    method: 'DELETE',
                    headers: {
                        "Accept": "application/json",
                        "Content-type": "application/json",
                        "Authorization": `Bearer ${window.localStorage.getItem('access_token')}`,
                    },
                    success: function (response) {
                        // Check if page has enough items left otherwise set default pagination
                        //console.log($('#feed-posts-table tr').length - 1);
                        if ($('#feed-posts-table tr').length - 1 === 1) {
                            currentPage > 1 ? currentPage -= 1 : currentPage = 1
                        }
                        _fetchData();
                    },
                    error: function (error) {
                        console.error(error)
                    }
                });
            }
            /**
             * @desc Generate pagination
             * @param meta
             */
            function generatePagination(meta) {
                $paginationContainer.empty()
                for (let i = 1; i <= meta.last_page; i++) {
                    if (i === currentPage) {
                        $paginationContainer.append(`<li><button class="_evt-pagination-button selected" data-page="${i}">${i}</button></li>`)
                    } else {
                        $paginationContainer.append(`<li><button class="_evt-pagination-button" data-page="${i}">${i}</button></li>`)
                    }
                }
            }
        });
    </script>
@endsection
