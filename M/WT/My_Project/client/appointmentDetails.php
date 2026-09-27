<?php

session_start();

include("../db.php");


/* =========================================================
   LOGIN CHECK
   ========================================================= */

if(!isset($_SESSION["id"]))
{
    header("Location: ../login.php");
    exit();
}


/* =========================================================
   CLIENT ROLE CHECK
   ========================================================= */

if($_SESSION["role"] != "client")
{
    header("Location: ../dashboard.php");
    exit();
}


$client_id = $_SESSION["id"];

$username = $_SESSION["username"] ?? "";


/* =========================================================
   GET APPOINTMENT ID
   ========================================================= */

$appointment_id = isset($_GET["id"])
    ? intval($_GET["id"])
    : 0;


/* =========================================================
   ICON LIBRARY
   ========================================================= */

function icon($name)
{
    $icons = [

        'home' =>
        '<path d="M4 11.5 12 5l8 6.5"/>
         <path d="M6 10v9a1 1 0 0 0 1 1h4v-6h2v6h4a1 1 0 0 0 1-1v-9"/>',

        'user' =>
        '<circle cx="12" cy="8" r="3.5"/>
         <path d="M5 20c1.2-3.6 4-5.5 7-5.5s5.8 1.9 7 5.5"/>',

        'search' =>
        '<circle cx="10.5" cy="10.5" r="6"/>
         <path d="m20 20-4.8-4.8"/>',

        'calendar' =>
        '<rect x="4" y="5.5" width="16" height="14.5" rx="2"/>
         <path d="M4 10h16M8 3.5v3M16 3.5v3"/>',

        'briefcase' =>
        '<rect x="3.5" y="8" width="17" height="11" rx="2"/>
         <path d="M8.5 8V6a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v2"/>
         <path d="M3.5 13h17"/>',

        'chart' =>
        '<path d="M4 20V10M11 20V4M18 20v-7"/>
         <path d="M2.5 20.5h19"/>',

        'shield' =>
        '<path d="M12 3.5 19 6v6c0 4.4-3 7.8-7 8.5-4-.7-7-4.1-7-8.5V6z"/>
         <path d="m9 12 2 2 4-4.2"/>',

        'back' =>
        '<path d="M19 12H5"/>
         <path d="m12 19-7-7 7-7"/>',

        'logout' =>
        '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
         <path d="M16 17l5-5-5-5"/>
         <path d="M21 12H9"/>'
    ];


    $body = $icons[$name] ?? '';


    return '<svg viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="1.7"
        stroke-linecap="round"
        stroke-linejoin="round">' .
        $body .
        '</svg>';
}


/* =========================================================
   GET APPOINTMENT DETAILS
   ========================================================= */

$row = null;


if($appointment_id > 0)
{

    $sql = "SELECT appointments.*,
            users.name AS lawyer_name,
            users.email AS lawyer_email,
            lawyer_profiles.experience,
            lawyer_profiles.chamber_name,
            lawyer_profiles.address,
            lawyer_profiles.consultation_fee,
            specializations.name AS specialization_name

            FROM appointments

            JOIN lawyer_profiles
            ON appointments.lawyer_id =
               lawyer_profiles.lawyer_id

            JOIN users
            ON lawyer_profiles.user_id =
               users.user_id

            JOIN specializations
            ON lawyer_profiles.specialization_id =
               specializations.specialization_id

            WHERE appointments.appointment_id='$appointment_id'

            AND appointments.client_id='$client_id'";


    $result = mysqli_query($conn, $sql);


    if($result && mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);
    }

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">


<title>Appointment Details — LegalAid</title>


<link rel="icon"
      href="../logo/favicon-32.png">


<link rel="apple-touch-icon"
      href="../logo/apple-touch-icon.png">


<link rel="preconnect"
      href="https://fonts.googleapis.com">


<link rel="preconnect"
      href="https://fonts.gstatic.com"
      crossorigin>


<link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700&family=Inter:wght@400;500;600&display=swap"
      rel="stylesheet">


<link rel="stylesheet"
      href="appointmentDetails.css">

</head>


<body>


<div class="app">


    <!-- =====================================================
         SIDEBAR
         ===================================================== -->

    <nav class="sidebar">


        <!-- LOGO -->

        <a class="sidebar-logo"
           href="../dashboard.php">

            <img src="../logo/logo-icon.svg"
                 alt="LegalAid">

        </a>


        <!-- NAVIGATION -->

        <ul class="sidebar-nav">


            <!-- DASHBOARD -->

            <li title="Dashboard">

                <a href="../dashboard.php">

                    <?php echo icon('home'); ?>

                </a>

            </li>


            <!-- PROFILE -->

            <li title="Edit Profile">

                <a href="profile.php">

                    <?php echo icon('user'); ?>

                </a>

            </li>


            <!-- FIND LAWYER -->

            <li title="Find Lawyer">

                <a href="findLawyer.php">

                    <?php echo icon('search'); ?>

                </a>

            </li>


            <!-- APPOINTMENTS -->

            <li class="active"
                title="My Appointments">

                <a href="appointments.php">

                    <?php echo icon('calendar'); ?>

                </a>

            </li>


            <!-- CASES -->

            <li title="My Cases">

                <a href="cases.php">

                    <?php echo icon('briefcase'); ?>

                </a>

            </li>


            <!-- REPORTS -->

            <li title="Reports">

                <a href="reports.php">

                    <?php echo icon('chart'); ?>

                </a>

            </li>


        </ul>


        <!-- LOGOUT -->

        <div class="sidebar-bottom">

            <a href="../logout.php"
               title="Logout">

                <?php echo icon('logout'); ?>

            </a>

        </div>


    </nav>



    <!-- =====================================================
         MAIN
         ===================================================== -->

    <main class="main">


        <!-- =================================================
             TOPBAR
             ================================================= -->

        <header class="topbar">


            <div>

                <h1>
                    LegalAid
                </h1>

                <p class="subtitle">
                    Appointment Details
                </p>

            </div>


            <!-- ACCOUNT -->

            <div class="account">


                <div class="account-info">

                    <span class="account-name">

                        <?php
                        echo htmlspecialchars($username);
                        ?>

                    </span>

                    <span class="account-role">
                        Client
                    </span>

                </div>


                <div class="avatar">

                    <?php

                    echo strtoupper(
                        substr($username, 0, 1)
                    );

                    ?>

                </div>


            </div>


        </header>



        <!-- =================================================
             PAGE HEADING
             ================================================= -->

        <section class="page-heading">


            <div>

                <a class="back-link"
                   href="appointments.php">

                    <?php echo icon('back'); ?>

                    Back to My Appointments

                </a>


                <h2>
                    Appointment Details
                </h2>


                <p>
                    View the details of your appointment and lawyer.
                </p>

            </div>


        </section>



        <?php if($row): ?>


        <!-- =================================================
             APPOINTMENT DETAILS CARD
             ================================================= -->

        <section class="details-card">


            <!-- LAWYER INFORMATION -->

            <div class="section-header">

                <div>

                    <h3>
                        Lawyer Information
                    </h3>

                    <p>
                        Information about the lawyer for this appointment.
                    </p>

                </div>

            </div>


            <div class="details-grid">


                <!-- LAWYER -->

                <div class="detail-item">

                    <span class="detail-label">
                        Lawyer
                    </span>

                    <div class="lawyer-name">

                        <span class="person-avatar">

                            <?php

                            echo strtoupper(
                                substr(
                                    $row["lawyer_name"],
                                    0,
                                    1
                                )
                            );

                            ?>

                        </span>

                        <span>

                            <?php

                            echo htmlspecialchars(
                                $row["lawyer_name"]
                            );

                            ?>

                        </span>

                    </div>

                </div>


                <!-- EMAIL -->

                <div class="detail-item">

                    <span class="detail-label">
                        Email
                    </span>

                    <span class="detail-value">

                        <?php

                        echo htmlspecialchars(
                            $row["lawyer_email"]
                        );

                        ?>

                    </span>

                </div>


                <!-- SPECIALIZATION -->

                <div class="detail-item">

                    <span class="detail-label">
                        Specialization
                    </span>

                    <span class="tag">

                        <?php

                        echo htmlspecialchars(
                            $row["specialization_name"]
                        );

                        ?>

                    </span>

                </div>


                <!-- EXPERIENCE -->

                <div class="detail-item">

                    <span class="detail-label">
                        Experience
                    </span>

                    <span class="detail-value">

                        <?php

                        echo htmlspecialchars(
                            $row["experience"]
                        );

                        ?>

                        years

                    </span>

                </div>


                <!-- CHAMBER -->

                <div class="detail-item">

                    <span class="detail-label">
                        Chamber
                    </span>

                    <span class="detail-value">

                        <?php

                        echo htmlspecialchars(
                            $row["chamber_name"]
                        );

                        ?>

                    </span>

                </div>


                <!-- ADDRESS -->

                <div class="detail-item">

                    <span class="detail-label">
                        Address
                    </span>

                    <span class="detail-value">

                        <?php

                        echo htmlspecialchars(
                            $row["address"]
                        );

                        ?>

                    </span>

                </div>


                <!-- CONSULTATION FEE -->

                <div class="detail-item">

                    <span class="detail-label">
                        Consultation Fee
                    </span>

                    <span class="detail-value fee">

                        <?php

                        echo htmlspecialchars(
                            $row["consultation_fee"]
                        );

                        ?>

                    </span>

                </div>


            </div>


            <!-- =================================================
                 APPOINTMENT INFORMATION
                 ================================================= -->

            <div class="section-divider"></div>


            <div class="section-header">

                <div>

                    <h3>
                        Appointment Information
                    </h3>

                    <p>
                        Details about your scheduled appointment.
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

                        <?php

                        echo htmlspecialchars(
                            $row["appointment_date"]
                        );

                        ?>

                    </span>

                </div>


                <!-- TIME -->

                <div class="info-box">

                    <span class="info-label">
                        Appointment Time
                    </span>

                    <span class="info-value">

                        <?php

                        echo htmlspecialchars(
                            $row["appointment_time"]
                        );

                        ?>

                    </span>

                </div>


                <!-- STATUS -->

                <div class="info-box">

                    <span class="info-label">
                        Status
                    </span>

                    <span class="status-tag">

                        <?php

                        echo htmlspecialchars(
                            ucfirst(
                                $row["status"]
                            )
                        );

                        ?>

                    </span>

                </div>


            </div>


            <!-- =================================================
                 REASON
                 ================================================= -->

            <div class="reason-box">

                <span class="detail-label">
                    Reason for Appointment
                </span>

                <p>

                    <?php

                    echo nl2br(
                        htmlspecialchars(
                            $row["reason"]
                        )
                    );

                    ?>

                </p>

            </div>


        </section>


        <?php else: ?>


        <!-- =================================================
             APPOINTMENT NOT FOUND
             ================================================= -->

        <section class="empty-card">

            <div class="empty-icon">
                !
            </div>

            <h3>
                Appointment Not Found
            </h3>

            <p>
                The appointment could not be found or you do not
                have permission to view it.
            </p>

            <a class="button"
               href="appointments.php">

                Back to My Appointments

            </a>

        </section>


        <?php endif; ?>



        <!-- =================================================
             FOOTER
             ================================================= -->

        <footer class="footer">

            &copy;

            <?php
            echo date("Y");
            ?>

            LegalAid. All rights reserved.

        </footer>


    </main>


</div>


</body>

</html>