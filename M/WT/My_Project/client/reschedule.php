<?php

session_start();

include("../db.php");


/* =========================================
   LOGIN CHECK
========================================= */

if (!isset($_SESSION["id"])) {
    header("Location: ../login.php");
    exit();
}


$client_id = $_SESSION["id"];

$appointment_id = isset($_GET["id"])
    ? $_GET["id"]
    : "";

$message = "";

$message_type = "";



/* =========================================
   ICON FUNCTION
========================================= */

function icon($name)
{
    $icons = [

        /* ---------------------------------
           HOME
        --------------------------------- */

        "home" => '
            <svg viewBox="0 0 24 24" fill="none">

                <path
                    d="M3 10.5L12 3L21 10.5V21H14V15H10V21H3V10.5Z"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linejoin="round"
                />

            </svg>
        ',


        /* ---------------------------------
           USER
        --------------------------------- */

        "user" => '
            <svg viewBox="0 0 24 24" fill="none">

                <circle
                    cx="12"
                    cy="8"
                    r="4"
                    stroke="currentColor"
                    stroke-width="1.8"
                />

                <path
                    d="M4 21C4.8 16.8 7.5 14.5 12 14.5C16.5 14.5 19.2 16.8 20 21"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />

            </svg>
        ',


        /* ---------------------------------
           SEARCH / FIND LAWYER
        --------------------------------- */

        "search" => '
            <svg viewBox="0 0 24 24" fill="none">

                <circle
                    cx="11"
                    cy="11"
                    r="6.5"
                    stroke="currentColor"
                    stroke-width="1.8"
                />

                <path
                    d="M16 16L21 21"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />

            </svg>
        ',


        /* ---------------------------------
           CALENDAR
        --------------------------------- */

        "calendar" => '
            <svg viewBox="0 0 24 24" fill="none">

                <rect
                    x="3"
                    y="5"
                    width="18"
                    height="16"
                    rx="2"
                    stroke="currentColor"
                    stroke-width="1.8"
                />

                <path
                    d="M16 3V7M8 3V7M3 10H21"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />

            </svg>
        ',


        /* ---------------------------------
           BRIEFCASE
        --------------------------------- */

        "briefcase" => '
            <svg viewBox="0 0 24 24" fill="none">

                <rect
                    x="3"
                    y="7"
                    width="18"
                    height="14"
                    rx="2"
                    stroke="currentColor"
                    stroke-width="1.8"
                />

                <path
                    d="M8 7V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V7"
                    stroke="currentColor"
                    stroke-width="1.8"
                />

                <path
                    d="M3 12H21"
                    stroke="currentColor"
                    stroke-width="1.8"
                />

            </svg>
        ',


        /* ---------------------------------
           CHART / REPORTS
        --------------------------------- */

        "chart" => '
            <svg viewBox="0 0 24 24" fill="none">

                <path
                    d="M4 19V10"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />

                <path
                    d="M10 19V5"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />

                <path
                    d="M16 19V13"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />

                <path
                    d="M22 19V8"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />

            </svg>
        ',


        /* ---------------------------------
           LOGOUT
        --------------------------------- */

        "logout" => '
            <svg viewBox="0 0 24 24" fill="none">

                <path
                    d="M10 4H5C3.9 4 3 4.9 3 6V18C3 19.1 3.9 20 5 20H10"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />

                <path
                    d="M14 8L18 12L14 16"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />

                <path
                    d="M18 12H9"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />

            </svg>
        ',


        /* ---------------------------------
           ARROW LEFT
        --------------------------------- */

        "arrow-left" => '
            <svg viewBox="0 0 24 24" fill="none">

                <path
                    d="M19 12H5"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />

                <path
                    d="M12 19L5 12L12 5"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />

            </svg>
        ',


        /* ---------------------------------
           CALENDAR SMALL
        --------------------------------- */

        "calendar-small" => '
            <svg viewBox="0 0 24 24" fill="none">

                <rect
                    x="3"
                    y="5"
                    width="18"
                    height="16"
                    rx="2"
                    stroke="currentColor"
                    stroke-width="1.8"
                />

                <path
                    d="M16 3V7M8 3V7M3 10H21"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />

            </svg>
        '

    ];


    return $icons[$name] ?? "";
}



/* =========================================
   RESCHEDULE APPOINTMENT
========================================= */

if (isset($_POST["reschedule"])) {

    $new_date = $_POST["new_date"] ?? "";

    $new_time = $_POST["new_time"] ?? "";


    if ($new_date == "" || $new_time == "") {

        $message = "Please select a new date and time.";

        $message_type = "error";

    } else {

        $sql = "
            UPDATE appointments

            SET
                appointment_date = '$new_date',
                appointment_time = '$new_time',
                status = 'pending'

            WHERE appointment_id = '$appointment_id'

            AND client_id = '$client_id'

            AND status = 'accepted'
        ";


        if (mysqli_query($conn, $sql)) {

            if (mysqli_affected_rows($conn) > 0) {

                $message =
                    "Reschedule Request Sent Successfully";

                $message_type = "success";

            } else {

                $message =
                    "Unable to reschedule this appointment. It may no longer be accepted.";

                $message_type = "error";
            }

        } else {

            $message = "Reschedule Failed";

            $message_type = "error";
        }
    }
}



/* =========================================
   USER INFORMATION
========================================= */

$username = $_SESSION["username"] ?? "Client";

$avatar_letter = strtoupper(
    substr($username, 0, 1)
);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Reschedule Appointment — LegalAid
    </title>


    <link
        rel="icon"
        href="../logo/favicon-32.png"
    >


    <link
        rel="stylesheet"
        href="reschedule.css"
    >

</head>


<body>


<div class="app">


    <!-- =====================================
         SIDEBAR
    ====================================== -->

    <aside class="sidebar">


        <!-- LOGO -->

        <a
            href="../dashboard.php"
            class="sidebar-logo"
        >

            <img
                src="../logo/logo-icon.svg"
                alt="LegalAid"
            >

        </a>



        <!-- =================================
             SIX MAIN NAVIGATION ICONS
        ================================== -->

        <nav class="sidebar-nav">


            <!-- 1. DASHBOARD -->

            <a
                href="../dashboard.php"
                class="nav-link"
            >

                <span class="nav-icon">
                    <?= icon("home"); ?>
                </span>

                <span class="nav-tooltip">
                    Dashboard
                </span>

            </a>



            <!-- 2. PROFILE -->

            <a
                href="profile.php"
                class="nav-link"
            >

                <span class="nav-icon">
                    <?= icon("user"); ?>
                </span>

                <span class="nav-tooltip">
                    Profile
                </span>

            </a>



            <!-- 3. FIND LAWYER -->

            <a
                href="findLawyer.php"
                class="nav-link"
            >

                <span class="nav-icon">
                    <?= icon("search"); ?>
                </span>

                <span class="nav-tooltip">
                    Find Lawyer
                </span>

            </a>



            <!-- 4. APPOINTMENTS -->

            <a
                href="appointments.php"
                class="nav-link active"
            >

                <span class="nav-icon">
                    <?= icon("calendar"); ?>
                </span>

                <span class="nav-tooltip">
                    Appointments
                </span>

            </a>



            <!-- 5. CASES -->

            <a
                href="cases.php"
                class="nav-link"
            >

                <span class="nav-icon">
                    <?= icon("briefcase"); ?>
                </span>

                <span class="nav-tooltip">
                    Cases
                </span>

            </a>



            <!-- 6. REPORTS -->

            <a
                href="reports.php"
                class="nav-link"
            >

                <span class="nav-icon">
                    <?= icon("chart"); ?>
                </span>

                <span class="nav-tooltip">
                    Reports
                </span>

            </a>


        </nav>



        <!-- =================================
             LOGOUT
        ================================== -->

        <div class="sidebar-bottom">

            <a
                href="../logout.php"
                class="nav-link"
            >

                <span class="nav-icon">
                    <?= icon("logout"); ?>
                </span>

                <span class="nav-tooltip">
                    Logout
                </span>

            </a>

        </div>


    </aside>



    <!-- =====================================
         MAIN CONTENT
    ====================================== -->

    <main class="main">


        <!-- =================================
             TOPBAR
        ================================== -->

        <header class="topbar">


            <div>

                <h1>
                    LegalAid
                </h1>

                <p class="subtitle">
                    Reschedule Appointment
                </p>

            </div>



            <div class="account">


                <div class="account-info">

                    <span class="account-name">
                        <?= htmlspecialchars($username); ?>
                    </span>

                    <span class="account-role">
                        Client
                    </span>

                </div>


                <div class="avatar">

                    <?= htmlspecialchars($avatar_letter); ?>

                </div>


            </div>


        </header>



        <!-- =================================
             PAGE HEADING
        ================================== -->

        <section class="page-heading">


            <!-- BACK BUTTON -->

            <a
                href="appointments.php"
                class="back-link"
            >

                <span class="back-icon">
                    <?= icon("arrow-left"); ?>
                </span>

                Back to Appointments

            </a>


            <h2>
                Reschedule Appointment
            </h2>


            <p>
                Choose a new date and time for your appointment.
            </p>


        </section>



        <!-- =================================
             RESCHEDULE CARD
        ================================== -->

        <section class="reschedule-card">


            <!-- CARD HEADER -->

            <div class="card-header">


                <div class="card-icon">

                    <?= icon("calendar-small"); ?>

                </div>


                <div>

                    <h3>
                        Request a New Appointment Time
                    </h3>

                    <p>
                        Select your preferred date and time below.
                    </p>

                </div>


            </div>



            <!-- =================================
                 MESSAGE
            ================================== -->

            <?php if ($message != ""): ?>

                <div
                    class="message <?= $message_type; ?>"
                >

                    <span class="message-dot"></span>

                    <?= htmlspecialchars($message); ?>

                </div>

            <?php endif; ?>



            <!-- =================================
                 FORM
            ================================== -->

            <form
                method="post"
                class="reschedule-form"
            >


                <!-- NEW DATE -->

                <div class="form-group">

                    <label for="new_date">
                        New Date
                    </label>


                    <input
                        type="date"
                        id="new_date"
                        name="new_date"
                        required
                    >

                    <span class="form-hint">
                        Select the date you would like to request.
                    </span>

                </div>



                <!-- NEW TIME -->

                <div class="form-group">

                    <label for="new_time">
                        New Time
                    </label>


                    <input
                        type="time"
                        id="new_time"
                        name="new_time"
                        required
                    >

                    <span class="form-hint">
                        Select your preferred appointment time.
                    </span>

                </div>



                <!-- SUBMIT -->

                <div class="form-actions">

                    <button
                        type="submit"
                        name="reschedule"
                        class="submit-button"
                    >

                        Request Reschedule

                    </button>

                </div>


            </form>


        </section>



        <!-- =================================
             FOOTER
        ================================== -->

        <footer class="footer">

            © <?= date("Y"); ?> LegalAid.
            All rights reserved.

        </footer>


    </main>


</div>


</body>

</html>