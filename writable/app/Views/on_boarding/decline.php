<!DOCTYPE html>
<html>
<head>
    <title>Decline Popup</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f4f6fb;
        }

        /* Popup Background */
        .popup{
            display:flex;
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background:rgba(0,0,0,0.5);
            justify-content:center;
            align-items:center;
            z-index:9999;
        }

        /* Popup Box */
        .popup-content{
            background:#fff;
            width:450px;
            border-radius:20px;
            padding:30px;
            animation:popup .3s ease;
        }

        @keyframes popup{
            from{
                transform:scale(.8);
                opacity:0;
            }
            to{
                transform:scale(1);
                opacity:1;
            }
        }

        .popup-content h2{
            color:#4a00e0;
            margin-bottom:15px;
        }

        .popup-content p{
            color:#555;
            margin-bottom:15px;
            line-height:1.6;
        }

        textarea{
            width:100%;
            height:120px;
            border:1px solid #ddd;
            border-radius:12px;
            padding:12px;
            resize:none;
            outline:none;
            font-size:14px;
            box-sizing:border-box;
        }

        .btn-group{
            display:flex;
            justify-content:flex-end;
            gap:10px;
            margin-top:20px;
        }

        .cancel-btn{
            background:#e5e7eb;
            border:none;
            padding:12px 20px;
            border-radius:10px;
            cursor:pointer;
        }

        .submit-btn{
            background:#4a00e0;
            color:#fff;
            border:none;
            padding:12px 20px;
            border-radius:10px;
            cursor:pointer;
        }
    </style>
</head>

<body>

<!-- Popup -->
<div class="popup" id="declinePopup">

    <div class="popup-content">

        <h2>Decline Offer Letter</h2>

        <p>
            Please provide a reason for declining.
            A request mail will be sent to Bloom Solutions
            if you want to accept again.
        </p>

        <textarea
            id="reason"
            placeholder="Enter reason here..."></textarea>

        <div class="btn-group">

            <button class="cancel-btn"
                onclick="closePopup()">
                Cancel
            </button>

            <button class="submit-btn"
        onclick="window.location.href='<?= base_url('admin/onboard_login') ?>'">
    Submit
</button>

        </div>

    </div>

</div>

<script>

function closePopup(){
    document.getElementById(
        "declinePopup"
    ).style.display = "none";
}

function submitDecline(){

    let reason =
        document.getElementById("reason").value;

    if(reason.trim() === ""){
        alert("Please enter reason");
        return;
    }

    localStorage.setItem("show_decline_msg", "true");
    window.location.href = "onboard_login.html";
}

</script>

</body>
</html>