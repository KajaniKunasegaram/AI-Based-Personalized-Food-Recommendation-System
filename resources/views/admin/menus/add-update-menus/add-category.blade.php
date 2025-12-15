<html>
<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background: #eef1f5;
            padding: 40px 0;
        }

        .category-box {
            width: 500px;
            margin: auto;
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 12px 35px rgba(0,0,0,0.12);
        }

        .title {
            text-align: center;
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #222;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: 500;
            margin-bottom: 6px;
            display: block;
        }

        input[type="text"], textarea {
            width: 100%;
            border: 1px solid #cbd1d9;
            padding: 12px 14px;
            border-radius: 12px;
            font-size: 15px;
            outline: none;
            transition: 0.2s;
        }

        input:focus, textarea:focus {
            border-color: #2ecc71;
            box-shadow: 0 0 6px rgba(46,204,113,0.4);
        }

        textarea {
            height: 100px;
            resize: none;
        }

        /* ROUND IMAGE PREVIEW */
        .image-circle {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            border: 3px solid #bbb;
            margin: 10px auto 20px auto;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.25s ease;
            background: #f6f7f9;
        }

        .image-circle:hover {
            border-color: #2ecc71;
            background: #e5fff0;
        }

        .image-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-hint {
            text-align: center;
            color: #777;
            font-size: 14px;
        }

        /* Toggle Switch */
        .switch {
            position: relative;
            width: 60px;
            height: 32px;
            display: inline-block;
        }
        .switch input { display: none; }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0; left: 0;
            right: 0; bottom: 0;
            background: #ccc;
            transition: .4s;
            border-radius: 30px;
        }

        .slider:before {
            content: "";
            position: absolute;
            height: 26px;
            width: 26px;
            left: 3px;
            bottom: 3px;
            background: white;
            border-radius: 50%;
            transition: .4s;
        }

        input:checked + .slider {
            background: #2ecc71;
        }

        input:checked + .slider:before {
            transform: translateX(28px);
        }

        /* Save Button */
        .save-btn {
            width: 100%;
            padding: 14px;
            background: #2ecc71;
            color: white;
            text-align: center;
            font-size: 16px;
            letter-spacing: 0.5px;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: .2s;
        }

        .save-btn:hover {
            background: #27ae60;
        }

    </style>
</head>

<body>

    <div class="category-box">

        <div class="title">Add Category</div>

        <!-- ROUND IMAGE UPLOAD -->
        <div class="image-circle" onclick="document.getElementById('fileInput').click();">
            <span class="image-hint">Upload Image</span>
        </div>
        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
            <input type="file" id="cat_image" name="cat_image" style="display:none;">

            <div class="form-group">
                <label>Category Name</label>
                <input class="catname" name="cat_name" type="text" placeholder="Pizza, Burger, Drinks....">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea class="catname" name="cat_description" placeholder="Short description"></textarea>
            </div>

            <div class="form-group">
                <label>Status (Active / Inactive)</label><br>
                <label class="switch">
                    <input type="checkbox" name="cat_status" value="1" checked>
                    <span class="slider"></span>
                </label>
            </div>

            <div class="btns">
                <button onclick="closeModal()" type="button" class="btn-cancel">Cancel</button>
                <button type="submit" class="btn-save">Save</button>
            </div>
        </form>

    </div>

    @if(session('success'))
        <div id="successMessage" class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

<script>
   
   
    // Selected image view

    const cat_image=document.getElementById('cat_image');
    const imgBox = document.querySelector('.image-circle');

    cat_image.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;

        const img = document.createElement("img");
        img.src = URL.createObjectURL(file);

        imgBox.innerHTML = "";
        imgBox.appendChild(img);
    });

    setTimeout(function() {
        var msg = document.getElementById('successMessage');
        if(msg) {
            msg.style.display = 'none';
        }
    }, 3000);
</script>

</body>
</html>
