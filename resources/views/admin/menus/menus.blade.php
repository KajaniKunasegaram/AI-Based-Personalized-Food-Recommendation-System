
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
                box-shadow:0 5px 15px rgba(0,0,0,0.2);
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

        .catname , .des{
            width: 100%;
            border: 1px solid #cbd1d9;
            padding: 12px 14px;
            border-radius: 12px;
            font-size: 15px;
            outline: none;
            transition: 0.2s;
        }

        .des{
            height: 100px;
            resize: none;
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
                <div class="title">Add Category</div>

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
                        <textarea class="des" placeholder="Short description"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Availability</label><br>
                        <label class="switch">
                            <input type="checkbox" checked>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div class="btn">
                        <button class="btn-save">Save</button>
                        <button class="btn-cancel">Cancel</button>
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
        </script>
    </body>
</html>

