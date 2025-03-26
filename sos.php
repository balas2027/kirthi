<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency SOS System</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }
        
        .container {
            text-align: center;
            max-width: 500px;
            width: 100%;
            padding: 20px;
        }
        
        .sos-button {
            position: relative;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: none;
            margin: 0 auto;
        }
        
        .sos-button.default {
            background-color: white;
            color: #ef4444;
        }
        
        .sos-button.emergency {
            background-color: #ef4444;
            color: white;
            animation: pulse 1.5s infinite;
        }
        
        .sos-button:hover:not(.emergency) {
            transform: scale(1.1);
            background-color: #fee2e2;
        }
        
        .sos-button svg {
            width: 32px;
            height: 32px;
            margin-bottom: 5px;
        }
        
        .sos-button span {
            font-size: 14px;
            font-weight: bold;
        }
        
        .emergency-alert {
            background-color: #ef4444;
            color: white;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 9999px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 20px;
            animation: fadeIn 0.5s;
        }
        
        .emergency-alert .pulse {
            animation: pulse 1.5s infinite;
        }
        
        .alert-dialog {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
        }
        
        .alert-dialog.open {
            opacity: 1;
            pointer-events: all;
        }
        
        .alert-dialog-content {
            background-color: white;
            border-radius: 8px;
            width: 90%;
            max-width: 400px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .alert-dialog-header {
            margin-bottom: 20px;
        }
        
        .alert-dialog-title {
            font-size: 18px;
            font-weight: 600;
            color: #ef4444;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }
        
        .alert-dialog-description {
            color: #4b5563;
            font-size: 16px;
            line-height: 1.5;
        }
        
        .alert-dialog-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
        
        .alert-dialog-button {
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .alert-dialog-cancel {
            background-color: #f3f4f6;
            color: #4b5563;
            border: 1px solid #e5e7eb;
        }
        
        .alert-dialog-cancel:hover {
            background-color: #e5e7eb;
        }
        
        .alert-dialog-confirm {
            background-color: #ef4444;
            color: white;
            border: none;
        }
        
        .alert-dialog-confirm:hover {
            background-color: #dc2626;
        }
        
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="sos-app">
            <div class="flex flex-col items-center gap-3">
                <button id="sos-button" class="sos-button default">
                    <div class="flex flex-col items-center">
                        <svg id="sos-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                            <line x1="12" y1="9" x2="12" y2="13"></line>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg>
                        <span>SOS</span>
                    </div>
                </button>
                
                <div id="emergency-alert" class="emergency-alert" style="display: none;">
                    <span class="pulse">●</span>
                    Emergency Alert Active
                </div>
            </div>
            
            <div id="confirm-dialog" class="alert-dialog">
                <div class="alert-dialog-content">
                    <div class="alert-dialog-header">
                        <div class="alert-dialog-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                <line x1="12" y1="9" x2="12" y2="13"></line>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                            Confirm Emergency Alert
                        </div>
                        <div class="alert-dialog-description">
                            This will send an emergency signal to all connected users. Are you sure you want to proceed?
                        </div>
                    </div>
                    <div class="alert-dialog-footer">
                        <button id="cancel-button" class="alert-dialog-button alert-dialog-cancel">Cancel</button>
                        <button id="confirm-button" class="alert-dialog-button alert-dialog-confirm">Send Emergency Alert</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sosButton = document.getElementById('sos-button');
            const sosIcon = document.getElementById('sos-icon');
            const emergencyAlert = document.getElementById('emergency-alert');
            const confirmDialog = document.getElementById('confirm-dialog');
            const cancelButton = document.getElementById('cancel-button');
            const confirmButton = document.getElementById('confirm-button');
            
            let isEmergency = false;
            
            // Check if there's an active emergency in session
            <?php
            session_start();
            if (isset($_SESSION['emergency_active']) && $_SESSION['emergency_active']) {
                echo "isEmergency = true; activateEmergencyUI();";
            }
            ?>
            
            sosButton.addEventListener('click', function() {
                if (!isEmergency) {
                    confirmDialog.classList.add('open');
                }
            });
            
            sosButton.addEventListener('mouseenter', function() {
                if (!isEmergency) {
                    sosButton.style.transform = 'scale(1.1)';
                }
            });
            
            sosButton.addEventListener('mouseleave', function() {
                if (!isEmergency) {
                    sosButton.style.transform = 'scale(1)';
                }
            });
            
            cancelButton.addEventListener('click', function() {
                confirmDialog.classList.remove('open');
            });
            
            confirmButton.addEventListener('click', function() {
                confirmDialog.classList.remove('open');
                activateEmergency();
                
                // Send emergency alert to server
                sendEmergencyAlert();
            });
            
            function activateEmergency() {
                isEmergency = true;
                activateEmergencyUI();
                
                // Store emergency state in session
                fetch('<?php echo $_SERVER['PHP_SELF']; ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'activate_emergency=1'
                });
            }
            
            function activateEmergencyUI() {
                sosButton.classList.remove('default');
                sosButton.classList.add('emergency');
                sosIcon.style.stroke = 'white';
                emergencyAlert.style.display = 'flex';
            }
            
            function sendEmergencyAlert() {
                // Get user's location if possible
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            const location = {
                                latitude: position.coords.latitude,
                                longitude: position.coords.longitude
                            };
                            
                            // Send alert with location to server
                            fetch('<?php echo $_SERVER['PHP_SELF']; ?>', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: `send_alert=1&lat=${location.latitude}&lng=${location.longitude}`
                            })
                            .then(response => response.text())
                            .then(data => {
                                console.log('Alert sent:', data);
                            });
                        },
                        function(error) {
                            console.error('Error getting location:', error);
                            // Send alert without location
                            fetch('<?php echo $_SERVER['PHP_SELF']; ?>', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: 'send_alert=1'
                            });
                        }
                    );
                } else {
                    // Geolocation not supported, send alert without location
                    fetch('<?php echo $_SERVER['PHP_SELF']; ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'send_alert=1'
                    });
                }
            }
        });
    </script>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        
        if (isset($_POST['activate_emergency'])) {
            // Activate emergency state in session
            $_SESSION['emergency_active'] = true;
            exit;
        }
        
        if (isset($_POST['send_alert'])) {
            $location = null;
            if (isset($_POST['lat']) && isset($_POST['lng'])) {
                $location = [
                    'latitude' => floatval($_POST['lat']),
                    'longitude' => floatval($_POST['lng'])
                ];
            }
            
            // Simulate sending alerts to different services
            $results = [];
            
            // SMS alert
            $smsResult = sendAlert('sms', $location);
            $results['sms'] = $smsResult;
            
            // WhatsApp alert
            $whatsappResult = sendAlert('whatsapp', $location);
            $results['whatsapp'] = $whatsappResult;
            
            // Call alert
            $callResult = sendAlert('call', $location);
            $results['call'] = $callResult;
            
            // In a real application, you would actually send these alerts to services
            // For this demo, we'll just return the simulated results
            echo json_encode([
                'success' => true,
                'results' => $results
            ]);
            exit;
        }
    }
    
    function sendAlert($alertType, $location = null) {
        $locString = $location ? "at {$location['latitude']}, {$location['longitude']}" : "without location data";
        
        switch ($alertType) {
            case 'sms':
                return "SMS alert sent to emergency contacts $locString";
            case 'whatsapp':
                return "WhatsApp alert sent to emergency contacts $locString";
            case 'call':
                return "Emergency call made to emergency services $locString";
            default:
                return "Unknown alert type";
        }
    }
    ?>
</body>
</html>