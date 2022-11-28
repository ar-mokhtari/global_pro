<div class="countdown">
    <?php $clockId = 'clockdiv' . $id ?>
    <div id="<?= $clockId ?>" class="clock clockdiv">
        <div>
            <span class="days">000</span>
            <div class="smalltext">Days</div>
        </div>
        <div>
            <span class="hours">00</span>
            <div class="smalltext">Hours</div>
        </div>
        <div>
            <span class="minutes">00</span>
            <div class="smalltext">Minutes</div>
        </div>
        <div>
            <span class="seconds">00</span>
            <div class="smalltext">Seconds</div>
        </div>
    </div>
    <?php //$deadline = $event->getTimerDeadline() ?>
    <?php if ($deadline): ?>
        <script type="text/javascript">
            var deadline = new Date(Date.parse('<?= $deadline ?>'));
            codnitive.initializeCountdown('<?= $clockId ?>', deadline);
        </script>
    <?php endif; ?>
</div>
