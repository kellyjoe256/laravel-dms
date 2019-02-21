
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Design Credit</b>&nbsp;
                <a href="http://www.almsaeedstudio.com" target="_blank">
                Almsaeed Studio</a>
            </div>

            <strong>&copy;<?php

                $year = (int)date('Y');

                if ( $year == 2018 ) {
                    $copyright = 2018;
                } else {
                    $copyright = 2018 . ' &ndash; ' . $year;
                }

                echo ' ' . $copyright . ' ';
            
            ?>{{ Html::mailto('kellyjoe256@gmail.com', 'Wafukho Kelly Joseph', ['target' => '_blank']) }}.</strong> All rights reserved.
        </footer>
