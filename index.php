<?php 
    require 'naivebayes.php';

    $data = olahData(getData("dt_training.txt"));    
    
    function getData($file){
        $fh = fopen($file, "r");
        $i = 0;
    
        while (!feof($fh)) {
            $line[$i] = fgets($fh);
            $i++;
        }
               
        fclose($fh);
        return $line;
    }
    
    function olahData($data){
        $i = 0;
        $olah = null;
        foreach ($data as $d) {
            $olah[$i] = array_map("trim", explode(" ", $d));        
            $i++;
        }
        
        return $olah;
    }    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Näive Bayes Classifier</title>

    <!-- Bootstrap -->
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./bootstrap/css/bootstrap-narrow.css" rel="stylesheet">

</head>

<body>
    <div class="container">
        <div class="header clearfix">            
            <h3 class="text-muted" align='center' style="color:blue"><b>Sistem Rekomendasi Pembelian Album Musik K-Pop</b></h3>
            <br>
            <p class="text-justify"> Sistem ini memanfaatkan metode Naive Bayes untuk menghitung probabilitas dari data yang ada. Untuk mengetahui apakah toko daring termasuk direkomendasikan atau kurang direkomendasikan. 
            Dengan parameter perhitungan 3 variable yang meliputi: Range Harga Poduk, Kuantitas Chat dan Estimasi Kedatangan Produk.</p>
            <p>Keterangan Variable:</p>
            <p>1. Range Harga Produk:</p>
            <p>• Esatu: < Rp250.000,00 </p>
            <P>• Edua: Rp280.000,00 – Rp300.000,00</P>
            <P>• Etiga: > Rp300.000,00</P>
            <p>2. Kuantitas Chat:</p>
            <p>• Lambat: < 50%</p>
            <p>• Sedang: 50% - 75%</p>
            <p>• Cepat: > 75%</p>
            <p>3. Estimasi Kedatangan Produk:</p>
            <p>• Rsatu: 3 – 4 minggu </p>
            <p>• Rdua: 5 – 6 minggu </p>
            <p>• Rtiga: 7 – 8 minggu </p>
            <p>Jika hasil menunjukkan nilai 'Ya' maka toko daring termasuk direkomendasikan, 
            sedangkan apabila hasil menunjukkan nilai 'Tidak' maka toko daring kurang direkomendasikan. </p>
        </div>
        
        <div class="row">
            <form method="post">
                <div class="form-group">                    
                    <div class="col-md-4">
                        <label for="range">Range Harga Produk:</label>                        
                        <select name="range" id="in_range" class="form-control">
                            <option value="">None</option>
                            <option value="Rsatu">Rsatu</option>
                            <option value="Rdua">Rdua</option>
                            <option value="Rtiga">Rtiga</option>
                        </select>                        
                    </div>
                    <div class="col-md-4">
                        <label for="chat">Kuantitas Chat:</label>
                        <select name="chat" id="in_chat" class="form-control">
                            <option value="">None</option>
                            <option value="Lambat">Lambat</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Cepat">Cepat</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="estimasi">Estimasi Kedatangan Produk:</label>
                        <select name="estimasi" id="in_estimasi" class="form-control">
                            <option value="">None</option>
                            <option value="Esatu">Esatu</option>
                            <option value="Edua">Edua</option>
                            <option value="Etiga">Etiga</option>
                        </select>
                    </div>                                                            
                    <div class="col-md-12" style="margin : 30px 0">
                        <button class="btn btn-primary btn-block" type="submit">Go!</button>                            
                    </div>                        
                </div>                
            </form>
        </div>
        
        <?php
        if (isset($_POST)) {
            $data_test = @[$_POST['range'], $_POST['chat'] ,$_POST['estimasi']];

            $nb = new NaiveBayes($data, ["Range", "Chat", "Estimasi"]);
        
            $result = $nb->run()->predict($data_test);
            
            ?>
            
            <div class="row">            
            <div class="col-md-6">
                <pre>
                    <?php print_r($result); ?>
                </pre>
            </div>
            <div class="col-md-6">
                <label>Jadi, apakah toko daring direkomendasikan?</label>
                <?= array_keys($result)[0] ?>
            </div>
        </div>

        <?php            
        }        
        ?>
        
        
                

        <footer class="footer">
            <p> TUGAS AKHIR FASILKOM UDINUS A11.2017.10694 - Anisa Fitrianingtyas </p>
            <p>&copy; Original template by Yosyafat, 030 </p>
        </footer>

    </div> <!-- /container -->

    <!-- jQuery Slim (necessary for Bootstrap's JavaScript plugins) -->
    <script src="./bootstrap/js/jquery.slim.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="./bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
