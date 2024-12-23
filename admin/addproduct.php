<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm mới sản phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="file"],
        input[type="number"],
        textarea {
            width: calc(100% - 12px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        textarea {
            height: 80px;
            resize: vertical;
        }
        input[type="submit"] {
            background-color: black;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: white;
            color: black;
            box-shadow: inset 0px 0px 5px 5px rgba(0, 0, 0, 0.5);
        }
        img {
            display: block;
            margin-bottom: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <form action="../control/index.php?chucnang=xulythemmoi" method="post" enctype="multipart/form-data" class="them-right">
        <!-- Product ID is auto-incremented, no need to input -->
        
        <label for="name_product">Tên Sản Phẩm</label>
        <input type="text" name="name_product" id="name_product" required> <br>
        
        <label for="category_id">Mã Danh Mục</label>
        <input type="text" name="category_id" id="category_id" required> <br>
        
        <label for="price">Giá</label>
        <input type="number" name="price" id="price" min="0" required> <br>
        
        <label for="description">Mô tả</label>
        <textarea name="description" id="description" required></textarea> <br>
        
        <label for="ava">Hình ảnh</label>
        <input type="file" name="ava" id="ava" accept="image/*" required><br>
        
        <input type="submit" value="Thêm mới sản phẩm">
    </form>
</body>
</html>
