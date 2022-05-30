<!doctype html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Majoo</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
		<style>
			.daftar-product{
				position: relative;
				border: solid 1px black;
				padding: 10px;
			}
			.desc{
				height: 270px;
				overflow: hidden;
				margin-top: 10px;
			}
			.daftar-product{
				text-align: center;
			}
			.daftar-product label {
				width: 100%;
				font-weight: bolder;
				padding: 5px;
			}
			.daftar-product p{
				text-align: justify;
			}
			.btn-beli{
				margin-bottom: 20px;
			}
			footer{
				width: 100%;
				text-align: center;
				border: solid 1px black;
				padding: 10px;
				margin-top: 20px;
			}
		</style>
	</head>
	<body>
		<nav class="navbar navbar-dark bg-dark">
			<div class="container-fluid">
			<a class="navbar-brand" href="#">Majoo Teknologi Indonesia</a>
			</div>
		</nav>
		<div class="container-fluid">
			<h2>Produk</h2>
			<div class="row">
				<?php
				foreach($products->data as $k => $v){
				?>
				<div class="col-3">
					<div class="daftar-product">
						<img class="img-fluid" src="<?php echo $v->image_link?>"/>
					
						<label class="product-name"><?php echo $v->product_name?></label class="price">
						<label class="price"> Rp
							<?php 
							$price = number_format($v->price);
							echo $price;
							?>
						</label>
						
						<div class="desc">
						<p>
						<?php 
						$product_desc = strip_tags($v->product_desc); 
						$product_desc = substr($product_desc, 0, 370); 
						echo $product_desc?>
						</p>
						</div>
						<button class="btn-beli" id="btn">Beli</button>						
					</div>
				</div>
				<?php } ?>
			</div>			
		</div>
		<footer>
			<span>2019 @ PT Majoo Teknologi Indonesia</span>
		</footer>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
	</body>
</html>