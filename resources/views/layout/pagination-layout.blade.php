<!doctype html>
<html lang="en">

<head>
    <title>Pagination in Laravel 10 Using Bootstrap</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <style>
        .pagination {
            float: right;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container-fluid px-5 pt-3">
        <h4 class="text-center fw-bold border-bottom pb-3"> Pagination in Laravel 10 Using Bootstrap </h4>
        <div class="table-responsive pt-5">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Transaction Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Transaction Type</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($records as $rs)
                        <tr>
                            <td>{{ $rs->transaction_id }} </td>
                            <td>{{ $rs->full_name }} </td>
                            <td>{{ $rs->email }} </td>
                            <td>{{ $rs->phone_no }} </td>
                            <td>{{ $rs->transaction_type }} </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <p class="text-danger">No data found </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $records->links() }}
        </div>
    </div>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>


