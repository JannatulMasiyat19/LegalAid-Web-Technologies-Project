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


$lawyer_user_id = $_SESSION["id"];

$appointment_id = isset($_GET["id"])
    ? $_GET["id"]
    : "";


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
           MAIL
        --------------------------------- */
        "mail" => '
            <svg viewBox="0 0 24 24" fill="none">

                <rect
                    x="3"
                    y="5"
                    width="18"
                    height="14"
                    rx="2"
                    stroke="currentColor"
                    stroke-width="1.8"
                />

                <path
                    d="M3 7L12 13L21 7"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linejoin="round"
                />

            </svg>
        ',


        /* ---------------------------------
           PHONE
        --------------------------------- */
        "phone" => '
            <svg viewBox="0 0 24 24" fill="none">

                <path
                    d="M6.5 3H9L10.5 7L8.5 8.5C9.5 11 11 12.5 13.5 13.5L15 11.5L19 13V15.5C19 17 17.8 18 16.5 18C10 17.5 6.5 14 5 8.5C4.5 6.5 5 4 6.5 3Z"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linejoin="round"
                />

            </svg>
        ',


        /* ---------------------------------
           SMALL BRIEFCASE
        --------------------------------- */
        "briefcase-small" => '
            <svg viewBox="0 0 24 24" fill="none">

                <rect
                    x="3"
                    y="6"
                    width="18"
                    height="14"
                    rx="2"
                    stroke="currentColor"
                    stroke-width="1.8"
                />

                <path
                    d="M8 6V4C8 3.45 8.45 3 9 3H15C15.55 3 16 3.45 16 4V6"
                    stroke="currentColor"
                    stroke-width="1.8"
                />

            </svg>
        '
    ];


    return $icons[$name] ?? "";
}



/* =========================================
   GET LAWYER ID
========================================= */

$lawyer_id = 0;

$lawyer_sql = "
    SELECT lawyer_id
    FROM lawyer_profiles
    WHERE user_id = '$lawyer_user_id'
";

$lawyer_result = mysqli_query($conn, $lawyer_sql);

if ($lawyer_result && mysqli_num_rows($lawyer_result) > 0) {

    $lawyer_row = mysqli_fetch_assoc($lawyer_result);

    $lawyer_id = $lawyer_row["lawyer_id"];
}



/* =========================================
   GET APPOINTMENT DETAILS
========================================= */

$row = null;

if ($appointment_id != "" && $lawyer_id != 0) {

    $sql = "
        SELECT

            appointments.*,

            users.name AS client_name,
            users.email AS client_email,
            users.phone AS client_phone,

            lawyer_profiles.experience,
            lawyer_profiles.chamber_name,
            lawyer_profiles.address,
            lawyer_profiles.consultation_fee,

            specializations.name AS specialization_name

        FROM appointments

        JOIN users
            ON appointments.client_id = users.user_id

        JOIN lawyer_profiles
            ON appointments.lawyer_id = lawyer_profiles.lawyer_id

        LEFT JOIN specializations
            ON lawyer_profiles.specialization_id =
               specializations.specialization_id

        WHERE appointments.appointment_id = '$appointment_id'

        AND appointments.lawyer_id = '$lawyer_id'
    ";


    $result = mysqli_query($conn, $sql);


    if ($result && mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);
    }
}



/* =========================================
   USER INFORMATION
========================================= */

$username = $_SESSION["username"] ?? "Lawyer";

$avatar_letter = strtoupper(
    substr($username, 0, 1)
);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Appointment Details — LegalAid
    </title>

    <link rel="icon"
          href="../logo/favicon-32.png">

    <link rel="stylesheet"
          href="lawyerDetails.css">

</head>


<body>


<div class="app">


    <!-- =====================================
         SIDEBAR
    ====================================== -->

    <aside class="sidebar">


        <!-- LOGO -->

        <a href="../dashboard.php"
           class="sidebar-logo">

            <img src="../logo/logo-icon.svg"
                 alt="LegalAid">

        </a>



        <!-- =================================
             SIX MAIN NAVIGATION ICONS
        ================================== -->

        <nav class="sidebar-nav">


            <!-- 1. DASHBOARD -->

            <a href="../dashboard.php"
               class="nav-link">

                <span class="nav-icon">
                    <?= icon("home"); ?>
                </span>

                <span class="nav-tooltip">
                    Dashboard
                </span>

            </a>



            <!-- 2. PROFILE -->

            <a href="profile.php"
               class="nav-link">

                <span class="nav-icon">
                    <?= icon("user"); ?>
                </span>

                <span class="nav-tooltip">
                    Profile
                </span>

            </a>



            <!-- 3. FIND LAWYER -->

            <a href="findLawyer.php"
               class="nav-link">

                <span class="nav-icon">
                    <?= icon("search"); ?>
                </span>

                <span class="nav-tooltip">
                    Find Lawyer
                </span>

            </a>



            <!-- 4. APPOINTMENTS -->

            <a href="appointments.php"
               class="nav-link active">

                <span class="nav-icon">
                    <?= icon("calendar"); ?>
                </span>

                <span class="nav-tooltip">
                    Appointments
                </span>

            </a>



            <!-- 5. CASES -->

            <a href="cases.php"
               class="nav-link">

                <span class="nav-icon">
                    <?= icon("briefcase"); ?>
                </span>

                <span class="nav-tooltip">
                    Cases
                </span>

            </a>



            <!-- 6. REPORTS -->

            <a href="reports.php"
               class="nav-link">

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
             SEPARATE FROM THE 6 ICONS
        ================================== -->

        <div class="sidebar-bottom">

            <a href="../logout.php"
               class="nav-link">

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
                    Appointment Details
                </p>

            </div>



            <div class="account">


                <div class="account-info">

                    <span class="account-name">
                        <?= htmlspecialchars($username); ?>
                    </span>

                    <span class="account-role">
                        Lawyer
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


            <!-- ONLY BACK BUTTON -->

            <a href="../dashboard.php"
               class="back-link">

                <span class="back-icon">
                    <?= icon("arrow-left"); ?>
                </span>

                Back to Dashboard

            </a>


            <h2>
                Appointment Details
            </h2>


            <p>
                View the details of this client appointment.
            </p>


        </section>



        <!-- =================================
             APPOINTMENT DETAILS
        ================================== -->

        <?php if ($row): ?>


            <section class="details-card">


                <!-- =================================
                     CLIENT INFORMATION
                ================================== -->

                <div class="section-header">


                    <div class="section-icon">

                        <?= icon("user"); ?>

                    </div>


                    <div>

                        <h3>
                            Client Information
                        </h3>

                        <p>
                            Information about the client
                        </p>

                    </div>


                </div>



                <div class="details-grid">


                    <!-- CLIENT NAME -->

                    <div class="detail-item">

                        <span class="detail-label">
                            Client Name
                        </span>


                        <span class="detail-value lawyer-name">


                            <span class="person-avatar">

                                <?= strtoupper(
                                    substr(
                                        $row["client_name"] ?? "C",
                                        0,
                                        1
                                    )
                                ); ?>

                            </span>


                            <?= htmlspecialchars(
                                $row["client_name"] ?? "N/A"
                            ); ?>


                        </span>

                    </div>



                    <!-- EMAIL -->

                    <div class="detail-item">

                        <span class="detail-label">
                            Email
                        </span>


                        <span class="detail-value">


                            <span class="inline-icon">

                                <?= icon("mail"); ?>

                            </span>


                            <?= htmlspecialchars(
                                $row["client_email"] ?? "N/A"
                            ); ?>


                        </span>

                    </div>



                    <!-- PHONE -->

                    <div class="detail-item">

                        <span class="detail-label">
                            Phone
                        </span>


                        <span class="detail-value">


                            <span class="inline-icon">

                                <?= icon("phone"); ?>

                            </span>


                            <?= htmlspecialchars(
                                $row["client_phone"] ?? "N/A"
                            ); ?>


                        </span>

                    </div>


                </div>



                <!-- DIVIDER -->

                <div class="section-divider"></div>



                <!-- =================================
                     APPOINTMENT INFORMATION
                ================================== -->

                <div class="section-header">


                    <div class="section-icon">

                        <?= icon("calendar"); ?>

                    </div>


                    <div>

                        <h3>
                            Appointment Information
                        </h3>

                        <p>
                            Details about the scheduled appointment
                        </p>

                    </div>


                </div>



                <div class="appointment-info-grid">


                    <!-- DATE -->

                    <div class="info-box">

                        <span class="info-label">
                            Appointment Date
                        </span>


                        <span class="info-value">

                            <?= htmlspecialchars(
                                $row["appointment_date"] ?? "N/A"
                            ); ?>

                        </span>

                    </div>



                    <!-- TIME -->

                    <div class="info-box">

                        <span class="info-label">
                            Appointment Time
                        </span>


                        <span class="info-value">

                            <?= htmlspecialchars(
                                $row["appointment_time"] ?? "N/A"
                            ); ?>

                        </span>

                    </div>



                    <!-- STATUS -->

                    <div class="info-box">

                        <span class="info-label">
                            Status
                        </span>


                        <?php

                        $status =
                            $row["status"] ?? "Pending";

                        ?>


                        <span class="status-tag">

                            <?= htmlspecialchars(
                                ucfirst($status)
                            ); ?>

                        </span>


                    </div>



                    <!-- REASON -->

                    <div class="info-box reason-box">

                        <span class="info-label">
                            Reason
                        </span>


                        <span class="info-value">

                            <?= nl2br(
                                htmlspecialchars(
                                    $row["reason"]
                                    ?? "No reason provided."
                                )
                            ); ?>

                        </span>


                    </div>


                </div>



                <!-- DIVIDER -->

                <div class="section-divider"></div>



                <!-- =================================
                     LAWYER INFORMATION
                ================================== -->

                <div class="section-header">


                    <div class="section-icon">

                        <?= icon("briefcase-small"); ?>

                    </div>


                    <div>

                        <h3>
                            Lawyer Information
                        </h3>

                        <p>
                            Your professional profile information
                        </p>

                    </div>


                </div>



                <div class="details-grid">


                    <!-- SPECIALIZATION -->

                    <div class="detail-item">

                        <span class="detail-label">
                            Specialization
                        </span>


                        <span class="detail-value">

                            <?= htmlspecialchars(
                                $row["specialization_name"]
                                ?? "Not specified"
                            ); ?>

                        </span>

                    </div>



                    <!-- EXPERIENCE -->

                    <div class="detail-item">

                        <span class="detail-label">
                            Experience
                        </span>


                        <span class="detail-value">

                            <?= htmlspecialchars(
                                $row["experience"]
                                ?? "Not specified"
                            ); ?>

                        </span>

                    </div>



                    <!-- CHAMBER -->

                    <div class="detail-item">

                        <span class="detail-label">
                            Chamber
                        </span>


                        <span class="detail-value">

                            <?= htmlspecialchars(
                                $row["chamber_name"]
                                ?? "Not specified"
                            ); ?>

                        </span>

                    </div>



                    <!-- ADDRESS -->

                    <div class="detail-item">

                        <span class="detail-label">
                            Address
                        </span>


                        <span class="detail-value">

                            <?= htmlspecialchars(
                                $row["address"]
                                ?? "Not specified"
                            ); ?>

                        </span>

                    </div>



                    <!-- CONSULTATION FEE -->

                    <div class="detail-item">

                        <span class="detail-label">
                            Consultation Fee
                        </span>


                        <span class="detail-value fee">

                            <?= htmlspecialchars(
                                $row["consultation_fee"]
                                ?? "Not specified"
                            ); ?>

                        </span>

                    </div>


                </div>


            </section>


        <?php else: ?>


            <!-- =================================
                 EMPTY STATE
            ================================== -->

            <section class="empty-card">


                <div class="empty-icon">

                    <?= icon("calendar"); ?>

                </div>


                <h3>
                    Appointment Not Found
                </h3>


                <p>
                    The appointment could not be found or you do
                    not have permission to view it.
                </p>


            </section>


        <?php endif; ?>



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