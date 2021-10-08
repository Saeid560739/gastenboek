<?php
$jsondata = null;
if(file_exists("data.json")) {
     $jsondata = file_get_contents("data.json");
     } else { 
         $data = [];
         $jsondata = json_encode($data);
     }

/*$data = [
    ["naam"=>"mark", "placed"=>"2021-10-5", "message"=>"Dit is een bericht"],
    ["naam"=>"willem", "placed"=>"2021-10-6", "message"=>"Dit is een bericht"],
    ["naam"=>"jan", "placed"=>"2021-10-7", "message"=>"Dit is een bericht"]

];
*/
//$jsondata = json_encode($data);
//file_put_contents("data.json",$jsondata);

if(isset($_POST['submit' ])) {
    if(isset($_COOKIE['gastenboek'])) {
        header("Location:" . $_SERVER['PHP_SELF']."");
        exit();
        
    }
    $data = json_decode($jsondata, true);
    $title = $_POST['title'];
    $message = $_POST['message'];
    $datum = new DateTime("now");
    $item = ["naam"=>$title, "placed" =>$datum->format('Y-m-d'), "message"=> $message];
    array_push($data, $item); 
    $jsondata = Json_encode($data); 
    file_put_contents("data.json", $jsondata);
    setcookie("gastenboek", "true", time() +3600);
    header("Location:" . $_SERVER['PHP_SELF']."");
     exit();


} 

//$data = json_decode($jsondata, true);

function write_messages_html($message_data) {
    $html = null; 
    foreach ($message_data as $item) {
         $name = $item['naam']; 
         $placed = $item['placed']; 
         $message = $item['message']; 
         $html .= <<< CODE
         <article>
           <div>
               <div class="name_title">$name</div>
               <div class="date">$placed</div> 
               <div class="message">$message</div> 
           </div>
         </article>
   CODE;
    }
    return $html;
   }  
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
            article { 
                border: 1px solid black; 
                border-radiUs: 10px; 
                background-color: blanchedalmond; 
                height: 100px; 
                width: 80%; 
                margin: 1% auto; 
                padding: 1%; 
            }
                .message_item1 { 
                    font-weight: bold; 
                    font-Size: 1.1rem; 
                }
                .message_item2 {
                    font-size: 0.8rem;
                 }
                .message_item3 {
                    margin-top: 1%;
                    font-size: 0.9rem;
                } 
                .modal {
                    display: none;
                    position: fixed;
                    Z-Index: 1;
                    left: 50%;
                    top: 50%;
                    width: 60%;
                    height: 50%;
                    transform: translate(-50%, -50%);
                    overflow: auto;
                    background-color: rgb(0,0,0);
                    background-color: rgba(0,0,0,0.4);
                    padding: 1%;
                    border: 2% solid black;
                    border-radius: 10px;

                }
        </style>
</head>
<body>
    <nav> <button onclick="T_addWindow();">Toevoegen bericht</button></nav>
    <main>
    <div class="modal" id="add_window"> 
           <form action="Index.php" method="post"> 
               <input type="text" name="title" placenolder="bericht titel">
               <input type="text" name="message" placeholder="bericht"> 
               <input type="submit" name="submit"> 
            </form>
        </div> 
        <div id="message_container"></div>
            
    </main>


<script>
    let jsondata = '<?=$jsondata?>';
    let berichten = JSON.parse(jsondata);

        berichten_to_html(berichten); 
    
    function berichten_to_html(d) {
         d.forEach(function(b) {
             let art = document.createElement("article"); 
             let adiv = document.createElement("div"); 
             let i = 1;
             
             for (prop in b) {
                  adivele = document.createElement("div"); 
                  adivele.setAttribute("class","message_item" + i); 

                  adivele.innerText = b[prop]; 
                  adiv.appendChild(adivele);
                  i++;
                   
             }
             art.appendChild(adiv); 
             document.getElementById("message_container").appendChild(art);
         });
    }; 
    function T_addWindow() {
        let e = document.getElementById("add_window"); 
        console.log(e.style.display); 
        if(e.style.display=="none" || e.style.display==undefined || e.style.display=="") { 
            document.getElementById("add_window").style.display = "block"; 
        }else {
            document.getElementById("add_window").style.display = "none"; 

            
        }
    }
</script>

</body>
</html>