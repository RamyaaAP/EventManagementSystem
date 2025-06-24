<div class="container">
    <div class="col-md-12">
        <hr>
    </div>

    <div class="row">
        <section>
            <div class="container">
                <div class="col-md-6">
                    <!-- <?php
                    if (isset($row['img_link'])) {
                        echo '<img src="' . htmlspecialchars($row['img_link']) . '" class="flow-control" alt="Event Image" style="width: 100%; height: auto;">';
                    } else {
                        echo '<img src="placeholder.jpg" class="img-responsive" alt="Placeholder Image" style="width: 100%; height: auto;">';
                    }
                    ?> -->
                </div>
                <div class="subcontent col-md-6">
                    <h1 style="color:#003300; font-size:38px;">
                        <u><strong>
                            <?php
                            echo isset($row['event_title']) ? htmlspecialchars($row['event_title']) : 'Event Title';
                            ?>
                        </strong></u>
                    </h1>
                    <p style="color:#003300; font-size:20px;">
                        <?php
                        if (isset($row['dept'])) {
                            echo '<strong>THE </strong>' . htmlspecialchars($row['dept']) . '<br>';
                        }
                        if (isset($row['Date'])) {
                            $formatted_date = date('d-m-Y', strtotime($row['Date']));
                            echo 'Date: ' . htmlspecialchars($formatted_date) . '<br>';
                        }
                        if (isset($row['time'])) {
                            $formatted_time = date('h:i A', strtotime($row['time']));
                            echo 'Time: ' . htmlspecialchars($formatted_time) . '<br>';
                        }
                        if (isset($row['location'])) {
                            echo 'Location: ' . htmlspecialchars($row['location']) . '<br>';
                        }
                        if (isset($row['st_name'])) {
                            echo 'Student Co-ordinator: ' . htmlspecialchars($row['st_name']) . '<br>';
                        }
                        if (isset($row['st_phone'])) {
                            echo 'Student Co-ordinator Phone number: ' . htmlspecialchars($row['st_phone']) . '<br>';
                        }
                        if (isset($row['name'])) {
                            echo 'Staff Co-ordinator: ' . htmlspecialchars($row['name']) . '<br>';
                        }
                        if (isset($row['phone'])) {
                            echo 'Staff Co-ordinator Phone number: ' . htmlspecialchars($row['phone']) . '<br>';
                        }
                        if (isset($row['rules'])) {
                            $rules_paragraphs = explode("\n", $row['rules']);
                            echo '<div style="font-family: Arial, sans-serif;">';
                            echo '<strong style="font-size: 24px;">Rules and Regulations:</strong>';
                            foreach ($rules_paragraphs as $paragraph) {
                                echo '<p style="font-size: 18px;">' . htmlspecialchars($paragraph) . '</p>';
                            }
                            echo '</div>';
                        }
                        ?>
                    </p>
                    <br><br>
                    <?php
                    echo '<a class="btn btn-default" href="register.php"><span class="glyphicon glyphicon-circle-arrow-right"></span> Register</a>';
                    ?>
                </div><!-- subcontent div -->
            </div><!-- container div -->
        </section>
    </div><!-- row div -->
</div><!-- container div -->
