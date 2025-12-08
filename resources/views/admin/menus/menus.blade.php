
 <html>
    <head>
        <style>
          
            .card{
                background-color: #fff;
                border-radius: 0.5rem;
                box-shadow: 0 2px 6px rgba(0,0,0,0.1); /* subtle shadow */
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .buttons {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                align-items: center;
                gap: 0.5rem;
            }
            .search-input{
                width: 60%;
                padding: 5px 5px 5px 10px;
                border-radius:8px;
                border: 1px solid #28a745;
                outline: none;
                transition: all 0.2s ease;
            }



            /* Category Model */
            .modal-overlay {
                position: fixed;
                top:0;
                left:0;
                width:100%;
                height:100%;
                background: rgba(0,0,0,0.5);
                display:none; /* hidden by default */
                justify-content:center;
                align-items:center;
                z-index:1000;
            }

            .modal-overlay.show {
                display:flex;
            }

            .category-box {
                background:#fff;
                padding:20px;
                border-radius:10px;
                width:500px;
                max-width:90%;
                /* height:90%; */
                box-shadow:0 5px 15px rgba(0,0,0,0.2);
            }

            .title {
                text-align: center;
                font-size: 26px;
                font-weight: 600;
                margin-bottom: 50px;
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

            .catname {
                width: 100%;
                border: 1px solid #cbd1d9;
                padding: 8px 10px;
                border-radius: 8px;
                font-size: 15px;
                outline: none;
                transition: 0.2s;
            }


        
            /* ROUND IMAGE PREVIEW */
            .image-circle {
                width: 150px;
                height: 150px;
                border-radius: 50%;
                border: 3px solid #bbb;
                margin: 40px auto 20px auto;
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
            .status{
                display:flex;
                gap:10px;
                justify-content:space-between;
                border:none;
                margin-bottom:20px;
            }
           .switch {
                position: relative;
                width: 40px;  
                height: 20px; 
                display: inline-block;
            }

            .switch input { display: none; }

            .slider {
                position: absolute;
                cursor: pointer;
                top: 0; left: 0;
                right: 0; bottom: 0;
                background: #ddd;    
                transition: .3s;
                border-radius: 20px;
            }

            .slider:before {
                content: "";
                position: absolute;
                height: 14px; 
                width: 14px;
                left: 3px;
                bottom: 3px;
                background: white;
                border-radius: 50%;
                transition: .3s;
            }

            input:checked + .slider {
                background: #2ecc71; 
            }

            input:checked + .slider:before {
                transform: translateX(20px);   
            }
            /* Save Button */
            .btns{
                display:flex;
                gap:10px;
                justify-content:flex-end;
                border:none;
            }
            .btn-save {
                width: 30%;
                padding: 8px;
                background: #2ecc71;
                color: white;
                text-align: center;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                /* transition: .2s; */
            }

            .btn-save:hover {
                background: #27ae60;
            }

            .btn-cancel {
                width: 30%;
                padding: 5px;
                background: white;
                color: #c00000ff;
                text-align: center;
                border:1px solid #c00000ff;
                border-radius: 8px;
                cursor: pointer;
                /* transition: .2s; */
            }

            .btn-cancel:hover {
                background: #c00000ff;
                color: white;
                /* background: #a70000ff; */
            }
        </style>
    </head>

    <body>
        <div id="categories" >
            <div class="card">
                <div class="buttons">
                    <input type="text" class="search-input" id="searchInput" placeholder="Search here...">
                    <div class="d-flex gap-2">           
                        <button id="toggleCollapseBtn" class="btn border-success text-success">Collapse All</button>
                        <button class="btn border-success text-success" data-bs-toggle="modal" data-bs-target="#sortCategoriesModal">Sort Categories</button>
                        <!-- <a href="{{route('add-category')}}" class="btn border-success text-success">Add Category</a> -->
                        <button onclick="openCategoryModal()" class="btn border-success text-success">Add Category</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="addCategoryModal" class="modal-overlay">
            <div class="category-box">
                <div class="modal-header justify-content-center position-relative">
                    <h5 class="modal-title text-center" id="addCategoryLabel">Add Category</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 m-3" onclick="closeModal()"></button>
                </div>
                 <!-- <div class="title">Add Category</div> -->
               
                <div class="image-circle" onclick="document.getElementById('fileInput').click();">
                    <span class="image-hint">Upload Image</span>
                </div>
                <input type="file" id="fileInput" style="display:none;">

                <form>
                    <div class="form-group">
                        <label>Category Name</label>
                        <input class="catname" type="text" placeholder="Pizza, Burger, Drinks....">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="catname" placeholder="Short description"></textarea>
                    </div>

                    <div class="status">
                        <label>Availability</label><br>
                        <label class="switch">
                            <input type="checkbox" checked>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div class="btns">
                        <button class="btn-cancel">Cancel</button>
                        <button class="btn-save">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function openCategoryModal() {
                document.getElementById('addCategoryModal').classList.add('show');
            }

            function closeModal() {
                document.getElementById('addCategoryModal').classList.remove('show');
            }

            // Optional: click outside modal to close
            window.addEventListener('click', function(e){
                const modal = document.getElementById('addCategoryModal');
                if(e.target === modal){
                    closeModal();
                }
            });

            // Selected image view

            const fileInput=document.getElementById('fileInput');
            const imgBox = document.querySelector('.image-circle');

            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (!file) return;

                const img = document.createElement("img");
                img.src = URL.createObjectURL(file);

                imgBox.innerHTML = "";
                imgBox.appendChild(img);
            });
        </script>
    </body>
</html>

