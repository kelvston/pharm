

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pharmacy Management')</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Add this to the <head> section for CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Add this to the end of your body section for JavaScript -->

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .custom-bg {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            /*background: rgba(147, 172, 197, 0.66);*/
        }

        .faded-text {
            position: absolute;
            top: 50%; /* Center vertically */
            left: 50%; /* Center horizontally */
            transform: translate(-50%, -50%); /* Offset the element by half of its width and height */
            color: rgba(255, 255, 255, 0.8); /* Adjust opacity for fading */
            font-size: 5rem; /* Adjust font size */
            font-weight: bold;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Optional: adds shadow for better visibility */
        }

        body {
            background-image:url('{{ asset('images/background1.png') }}');
        ;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Arial', sans-serif;
        }


                                                       /*.suggestion-item {*/
        /*    display: flex;*/
        /*    justify-content: space-between;*/
        /*    align-items: center;*/
        /*}*/

        /*.suggestion-item strong {*/
        /*    flex: 1;*/
        /*}*/

        .suggestion-item .text-muted {
            font-style: italic;
        }

        .suggestion-item .text-info {
            color: #b88a17;
        }

        #medicine-search {
            width: 100%;
        }

        /*#medicine-suggestions {*/
        /*    width: 100%; !* Ensure the list takes the same width as the input *!*/
        /*    position: absolute; !* Position suggestions below the input *!*/
        /*    z-index: 1000; !* Make sure the suggestions appear on top of other elements *!*/
        /*    max-height: 200px; !* Optional: Limit the height if too many suggestions appear *!*/
        /*    overflow-y: auto; !* Enable scrolling if the list exceeds max-height *!*/
        /*}*/

        body {
            font-family: 'Nunito', sans-serif;
            /*background-color: #f8f9fa;*/
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 240px;
            background-color: rgba(147, 172, 197, 0.66);
            color: #fff;
            padding-top: 60px; /* Navbar height */
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .sidebar .list-group-item {
            background-color: #343a40;
            color: #adb5bd;
            border: none;
            transition: background-color 0.3s, color 0.3s;
        }

        /*.sidebar .list-group-item:hover {*/
        /*    background-color: #495057;*/
        /*    color: #fff;*/
        /*}*/

        .sidebar .list-group-item.active {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            border-radius: 5px;
        }

        .sidebar .list-group-item i {
            margin-right: 15px;
        }

        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            color: #007bff;
        }

        .navbar-brand:hover {
            color: #0056b3;
        }

        .navbar .form-control {
            border-radius: 20px;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                width: 100%;
                height: auto;
            }
        }
        /*#medicine-suggestions {*/
        /*    position: absolute;*/
        /*    z-index: 1000;*/
        /*    width: 100%;*/
        /*    max-height: 200px;*/
        /*    overflow-y: auto;*/
        /*    background: white;*/
        /*    border: 1px solid #ccc;*/
        /*    border-radius: 4px;*/
        /*    margin-top: 5px;*/
        /*}*/

        .suggestion-item {
    padding: 8px;
            cursor: pointer;
        }


        .sidebar .list-group-item:hover {
            background-color: #70F4F8 !important; /* Ensure it overrides any other rules */
        }

        .list-group-item {
            background-color:  rgba(147, 172, 197, 0.66) !important;
            color: #101115  !important;
        }

    </style>

</head>
<header>
    <!-- Sidebar -->
    <nav id="sidebarMenu" class="sidebar" >
        <div class="list-group list-group-flush" >
            <a href="/dashboard" class="list-group-item list-group-item-action active" >
                <i class="fas fa-tachometer-alt"></i>Main Dashboard
            </a>
            <!-- Medications -->
            <a href="/inventory" class="list-group-item list-group-item-action py-2 ripple">
                <i class="fas fa-pills fa-fw me-3"></i><span>Medications</span>
            </a>

            <!-- Inventory -->
            <a href="/inventory" class="list-group-item list-group-item-action py-2 ripple">
                <i class="fas fa-boxes fa-fw me-3"></i><span>Inventory Management</span>
            </a>
            <!-- Sales -->
            <a href="/sales" class="list-group-item list-group-item-action py-2 ripple">
                <i class="fas fa-cash-register fa-fw me-3"></i><span>Sales</span>
            </a>
            <!-- Reports -->
            <a href="/sales-report" class="list-group-item list-group-item-action py-2 ripple">
                <i class="fas fa-chart-bar fa-fw me-3"></i><span>Reports</span>
            </a>
            <a href="/expenses" class="list-group-item list-group-item-action py-2 ripple">
                <i class="fas fa-chart-bar fa-fw me-3"></i><span>Expense</span>
            </a>
            <!-- Suppliers -->
            <a href="/suppliers" class="list-group-item list-group-item-action py-2 ripple">
                <i class="fas fa-truck fa-fw me-3"></i><span>Suppliers</span>
            </a>
            <!-- Staff Management -->
            <a href="/staff" class="list-group-item list-group-item-action py-2 ripple">
                <i class="fas fa-users fa-fw me-3"></i><span>Staff Management</span>
            </a>
            <!-- User Profile -->
            <a href="/profile" class="list-group-item list-group-item-action py-2 ripple">
                <i class="fas fa-user fa-fw me-3"></i><span>My Profile</span>
            </a>
            <!-- Settings -->
            <a href="/settings" class="list-group-item list-group-item-action py-2 ripple">
                <i class="fas fa-cog fa-fw me-3"></i><span>Settings</span>
            </a>
        </div>
    </nav>

    <!-- Sidebar -->

    <!-- Navbar -->
    <nav
        id="main-navbar"
        class="navbar navbar-expand-lg navbar-light  fixed-top"
    style=" background-color: rgba(147, 172, 197, 0.66);">
        <!-- Container wrapper -->
        <div class="container-fluid">
            <!-- Toggle button -->
            <button
                class="navbar-toggler"
                type="button"
                data-mdb-toggle="collapse"
                data-mdb-target="#sidebarMenu"
                aria-controls="sidebarMenu"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <i class="fas fa-bars"></i>
            </button>

            <!-- Brand -->
            <a class="navbar-brand" href="#">Pharmacy</a>
            <!-- Search form -->
            <form class="d-none d-md-flex input-group w-auto my-auto">
                <input
                    autocomplete="off"
                    type="search"
                    class="form-control rounded"
                    placeholder='Search (ctrl + "/" to focus)'
                    style="min-width: 225px"
                />
                <span class="input-group-text border-0"
                ><i class="fas fa-search"></i
                    ></span>
            </form>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/inventory">Inventory</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('sales.index') }}">Sales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('staff.index') }}">Staff</a>
                    </li>
                </ul>

            </div>
            <!-- Right links -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
{{--                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="img-thumbnail mb-3" style="width: 150px; height: 150px;">--}}
{{--                            <img--}}
{{--                                src="{{ Auth::user()->profile_image ? asset('storage/' . $user->profile_picture) : asset('images/default-profile.png') }}"--}}
{{--                                alt="Profile Image"--}}
{{--                                class="rounded-circle"--}}
{{--                                style="width: 35px; height: 35px; object-fit: cover; margin-right: 10px;"--}}
{{--                            />--}}
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
</header>
<!--Main Navigation-->

<!--Main layout-->
@php
    $data = \App\Models\SystemSetting::first();
@endphp
<div class="faded-text">{{$data->pharmacy_name}}</div>

<main style="margin-top: 58px;" >
   <div class="container mt-4">
        @yield('content')
    </div>
</main>
<!--Main layout-->

<!-- Bootstrap JS -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}">
    // Graph
    var ctx = document.getElementById("myChart");

    var myChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: [
                "Sunday",
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday",
            ],
            datasets: [
                {
                    data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
                    lineTension: 0,
                    backgroundColor: "transparent",
                    borderColor: "#007bff",
                    borderWidth: 4,
                    pointBackgroundColor: "#007bff",
                },
            ],
        },
        options: {
            scales: {
                yAxes: [
                    {
                        ticks: {
                            beginAtZero: false,
                        },
                    },
                ],
            },
            legend: {
                display: false,
            },
        },
    });

</script>
</html>
