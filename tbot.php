<?php
$accessToken = "EAAMvltdL8ZBoBANn8aZCpDJ6PKu63ZAjLJ3cxizvhOTfn9K8eEaGMJuluUZC865kQ8ZBrnTdaMvB1J7fd2YLWo9AKQ7X32nhX8ZAy1zZAEffXbr3uZAQMZC8t7UmCPFWDPj5Lwl9cnFmO2UmZBoI7iSxtNGUG4SmAQHqr9dIIs0CGR2JT75zYVISJ0";

if(isset($_REQUEST['hub_challenge'])) {
  $c = $_REQUEST['hub_challenge'];
  $v = $_REQUEST['hub_verify_token'];
}

if($v == "abc123") {
  echo $c;
  
}


$counter;
$input = json_decode(file_get_contents('php://input'), true);
$pageID = $input['entry'][0]['id'];
$userID = $input['entry'][0]['messaging'][0]['sender']['id'];
$message = $input['entry'][0]['messaging'][0]['message']['text'];
$messagingArray =  $input['entry'][0]['messaging'][0]['postback']['payload'];
 //json decode url of user data array collection
   $ress = json_decode(file_get_contents("https://graph.facebook.com/v2.6/$userID?fields=first_name,last_name,profile_pic,locale,timezone,gender&access_token=$accessToken"), true);
   $rep = $ress['profile_pic'];
   $name = $ress['first_name'];

    
if($messagingArray == "payloadhelp"){
  
    first_option($userID, $input, $accessToken);


} elseif($messagingArray == "payloadstart"){
   
    sendTextMessage('Welcome '.$name.'! I am Tel-Eshtaol Bot, you can think of me as your personal spiritual trainer and advisor that sends you bible verses and lead you to the kingdom of christ.', $userID, $accessToken);
   //counts how many users we have and dumps it on the count.txt file
    $get= file_get_contents("count.txt");
    $get = $get + 1;
    file_put_contents("count.txt", $get);
    
} elseif($messagingArray == "payload1"){
    second_option($userID, $accessToken, $input, $message);
}elseif($messagingArray == "bibleverse"){
    $res = json_decode(file_get_contents('http://www.hagerigna.com/bot/verse.json'), true);
    $replyb = $res[rand(0,count($res)-1)]['verse'];
    //sendTextMessage($reply, $userID, $accessToken);
    $urlb = "https://graph.facebook.com/v2.6/me/messages?access_token=$accessToken";
$jsonDatab = "{
 'recipient': {
   'id': $userID
 },
 'message': {
 'attachment':{
      'type':'template',
      'payload':{
        'template_type':'button',
        'text': '$replyb',
        'buttons':[
          {
            'type':'postback',
            'title':'Other Bible Verse',
            'payload':'otrverse'
          }
         
        ]
      }
    }
  }
}";

//curl request for the messageing only
$chb = curl_init($urlb);
curl_setopt($chb, CURLOPT_POST, true);
curl_setopt($chb, CURLOPT_POSTFIELDS, $jsonDatab);
curl_setopt($chb, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);


 curl_exec($chb);
    $error = curl_error($chb);
    $response = curl_getinfo($chb, CURLINFO_HTTP_CODE);
    var_dump($error);
    var_dump($response);
    curl_close($chb);
    
}elseif($messagingArray == "otrverse"){
    //select random verse
    $res = json_decode(file_get_contents('http://www.hagerigna.com/bot/verse.json'), true);
    $replyb = $res[rand(0,count($res)-1)]['verse'];
    
    $urlb = "https://graph.facebook.com/v2.6/me/messages?access_token=$accessToken";
$jsonDatab = "{
 'recipient': {
   'id': $userID
 },
 'message': {
 'attachment':{
      'type':'template',
      'payload':{
        'template_type':'button',
        'text': '$replyb',
        'buttons':[
          {
            'type':'postback',
            'title':'Other Bible Verse',
            'payload':'otrverse'
          }
         
        ]
      }
    }
  }
}";

//curl request for the messageing only
$chb = curl_init($urlb);
curl_setopt($chb, CURLOPT_POST, true);
curl_setopt($chb, CURLOPT_POSTFIELDS, $jsonDatab);
curl_setopt($chb, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

 curl_exec($chb);
    $error = curl_error($chb);
    $response = curl_getinfo($chb, CURLINFO_HTTP_CODE);
    var_dump($error);
    var_dump($response);
    curl_close($chb);
}elseif($messagingArray == 'payloadshare'){
     $urlb = "https://graph.facebook.com/v2.6/me/messages?access_token=$accessToken";
$json = "{
 'recipient': {
   'id': $userID
 },
 'message': {
 'attachment':{
      'type':'template',
      'payload':{
        'template_type':'generic',
        'elements':[
          {
            'title':'Tel-Eshtaol',
            'subtitle':'Share This Page to your friends and spread the Gospel of Jesus Christ!',
            'image_url':'https://hagerigna.com/bot/bot.jpg',
            'buttons':[
              {
                'type':'element_share',
                'share_contents': { 
          'attachment': {
            'type': 'template',
            'payload': {
              'template_type': 'generic',
              'elements': [
                {
                  'title': 'Welcome To Tel-Eshtaol',
                  'subtitle': 'A Facebook page that leads people to the kingdom of christ!.',
                  'image_url': 'https://hagerigna.com/bot/bot.jpg',
                  'default_action': {
                   'type': 'web_url',
                    'url': 'https://www.facebook.com/TelEshtaol/'
                  },
                 
                  'buttons': [
                    {
                      'type': 'web_url',
                     'url': 'https://www.facebook.com/TelEshtaol/', 
                     'title': 'Goto Page'
                    }
                    
                  ]
                }
              ]
            }
          }
        }
        }              
            ]
          }
         ]
      }
    }
  }
}";

//curl request for the messageing only
$chb = curl_init($urlb);
curl_setopt($chb, CURLOPT_POST, true);
curl_setopt($chb, CURLOPT_POSTFIELDS, $json);
curl_setopt($chb, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);


 curl_exec($chb);
    $error = curl_error($chb);
    $response = curl_getinfo($chb, CURLINFO_HTTP_CODE);
    var_dump($error);
    var_dump($response);
    curl_close($chb);
    
}






scratch($accessToken);





//uploads pro pic
function uploadpropic(){
    global $rep;
    global $userID;
    global $accessToken;
    $urlbb = "https://graph.facebook.com/v2.6/me/messages?access_token=$accessToken";  
     $jsonDatabb = "{
 'recipient': {
   'id': $userID
 },
 'message': {
 'attachment':{
      'type':'image',
      'payload':{
      'url': '$rep'
      }
 }
 }
 }";

//curl request for the messageing only
$chbb = curl_init($urlbb);
curl_setopt($chbb, CURLOPT_POST, true);
curl_setopt($chbb, CURLOPT_POSTFIELDS, $jsonDatabb);
curl_setopt($chbb, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);


   curl_exec($chbb);
    $error = curl_error($chbb);
    $response = curl_getinfo($chbb, CURLINFO_HTTP_CODE);
    var_dump($error);
    var_dump($response);
    curl_close($chbb);

    
}




function scratch($accessToken){
    $url = "https://graph.facebook.com/v2.6/me/thread_settings?access_token=$accessToken";

$jsonData = "{


  'setting_type' : 'call_to_actions',
  'thread_state' : 'existing_thread',
  'call_to_actions':[

    {
      'type':'web_url',
      'title':'Home',
      'url':'https://habeshastudent.com'
    },
   
    {
      'type':'postback',
      'title':'Help',
      'payload':'payloadhelp'
    },
    {
      'type':'postback',
      'title':'Share',
      'payload':'payloadshare'
    }
    
  ]
  
  'thread_state' : 'new_thread',
  'call_to_actions':[
    {
      'type':'postback',
      'title':'Start',
     'payload':'payloadstart'
    }
  ]


    
}";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

 curl_exec($ch);
    $error = curl_error($ch);
    $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    var_dump($error);
    var_dump($response);
    curl_close($ch);
}



function first_option($userID, $input, $accessToken){
           $url = "https://graph.facebook.com/v2.6/me/messages?access_token=$accessToken";
           $resc = json_decode(file_get_contents('https://www.hagerigna.com/bot/clipjson.json'), true);
           $replyc = $resc[rand(0,count($resc)-1)]['verse'];
$jsonData = "{
 'recipient': {
   'id': $userID
 },
 'message': {
 'attachment':{
      'type':'template',
      'payload':{
        'template_type':'button',
        'text':'..What do you want to do..',
        'buttons':[
          {
            'type':'postback',
            'title':'Start Chatting',
            'payload':'payload1'
          },
          {
          
            'type':'web_url',
            'url':'$replyc',
            'title':'Watch short clip'
          },
          {
          'type':'phone_number',
          'title':'Contact TelEshtaol',
          'payload':'+251116174400'
          }
          
          
        ]
       
      }
    }
  }
}";

//curl request for the messageing only
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);


 curl_exec($ch);
    $error = curl_error($ch);
    $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    var_dump($error);
    var_dump($response);
    curl_close($ch);



}
 
function second_option($userID, $accessToken, $input, $message){
 $urlq = "https://graph.facebook.com/v2.6/me/messages?access_token=$accessToken";

$jsonDataq = "{
 'recipient': {
   'id': $userID
 },
 'message': {
 'attachment':{
      'type':'template',
      'payload':{
        'template_type':'button',
        'text':'Hello :)',
        'buttons':[
          {
            'type':'postback',
            'title':'Bible Verse',
            'payload':'bibleverse'
          },
          {
            'type':'postback',
            'title':'4 spiritual laws',
            'payload':'letstalk'
          },
          {
          'type':'postback',
          'title':'Go Back',
          'payload':'payloadhelp'
          }
        ]
      }
    }
  }
}";

//curl request for the messageing only
$chq = curl_init($urlq);
curl_setopt($chq, CURLOPT_POST, true);
curl_setopt($chq, CURLOPT_POSTFIELDS, $jsonDataq);
curl_setopt($chq, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);


 curl_exec($chq);
    $error = curl_error($chq);
    $response = curl_getinfo($chq, CURLINFO_HTTP_CODE);
    var_dump($error);
    var_dump($response);
    curl_close($chq);



}

function third_option($userID, $accessToken){
 
  $urlb = "https://graph.facebook.com/v2.6/me/messages?access_token=$accessToken";
$jsonDatab = "{
 'recipient': {
   'id': $userID
 },
 'message': {
 'attachment':{
      'type':'template',
      'payload':{
        'template_type':'button',
        'text': 'God loves you and has a wonderful plan for your life. John 3:16 teaches, For God so loved the world, that he gave his only Son, that whoever believes in him should not perish but have eternal life. John 10:10 (NIV) gives us the reason that Jesus came: I have come that they may have life, and have it to the full. The Four Spiritual Laws asks, What is blocking us from Gods love? What is preventing us from having an abundant life?The second spiritual law answers this question',
        'buttons':[
          {
            'type':'postback',
            'title':'2nd spiritual law',
            'payload':'seclaw'
          },
          {
            'type':'postback',
            'title':'Main Menu',
            'payload':'payloadhelp'
          }
         
        ]
      }
    }
  }
}";

//curl request for the messageing only
$chb = curl_init($urlb);
curl_setopt($chb, CURLOPT_POST, true);
curl_setopt($chb, CURLOPT_POSTFIELDS, $jsonDatab);
curl_setopt($chb, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

 curl_exec($chb);
    $error = curl_error($chb);
    $response = curl_getinfo($chb, CURLINFO_HTTP_CODE);
    var_dump($error);
    var_dump($response);
    curl_close($chb);
}



if ($messagingArray == "letstalk"){
    third_option($userID, $accessToken);
    
    }elseif ($messagingArray == "seclaw"){
    $urlb = "https://graph.facebook.com/v2.6/me/messages?access_token=$accessToken";
$jsonDatab = "{
 'recipient': {
   'id': $userID
 },
 'message': {
 'attachment':{
      'type':'template',
      'payload':{
        'template_type':'button',
        'text': 'Humanity is tainted by sin and is therefore separated from God. As a result, we cannot know Gods wonderful plan for our lives. Romans 3:23 states, for all have sinned and fall short of the glory of God. Romans 6:23 adds, the wages of sin is death. According to the Four Spiritual Laws, God created us to have fellowship with Him. However, humanity brought sin into the world, and is therefore separated from God. What is the solution? The third spiritual law answers by stating',
        'buttons':[
          {
            'type':'postback',
            'title':'3rd spiritual law',
            'payload':'thirdlaw'
          },
          {
            'type':'postback',
            'title':'Main Menu',
            'payload':'payloadhelp'
          }
         
        ]
      }
    }
  }
}";

//curl request for the messageing only
$chb = curl_init($urlb);
curl_setopt($chb, CURLOPT_POST, true);
curl_setopt($chb, CURLOPT_POSTFIELDS, $jsonDatab);
curl_setopt($chb, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

 curl_exec($chb);
    $error = curl_error($chb);
    $response = curl_getinfo($chb, CURLINFO_HTTP_CODE);
    var_dump($error);
    var_dump($response);
    curl_close($chb);
}elseif ($messagingArray == "thirdlaw"){
    $urlb = "https://graph.facebook.com/v2.6/me/messages?access_token=$accessToken";
$jsonDatab = "{
 'recipient': {
   'id': $userID
 },
 'message': {
 'attachment':{
      'type':'template',
      'payload':{
        'template_type':'button',
        'text': 'Jesus Christ is Gods only provision for our sin.Through Jesus Christ,we can have our sins forgiven and restore a right relationship with God. Rom 5:8 shares,but God shows his love for us in that while we were still sinners,Christ died for us. First Cor 15:3-4 says,For I delivered to you as of first importance what I also received:that Christ died for our sins in accordance with the Scriptures,that he was buried,that he was raised on the third day in accordance with the Scriptures. Jesus taught that He is the only way of salvation:I am the way,and the truth,and the life. No one comes to the Father except through me (John 14:6)',
        'buttons':[
          {
            'type':'postback',
            'title':'4th spiritual law',
            'payload':'fourthlaw'
          },
          {
            'type':'postback',
            'title':'Main Menu',
            'payload':'payloadhelp'
          }
         
        ]
      }
    }
  }
}";

//curl request for the messageing only
$chb = curl_init($urlb);
curl_setopt($chb, CURLOPT_POST, true);
curl_setopt($chb, CURLOPT_POSTFIELDS, $jsonDatab);
curl_setopt($chb, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

 curl_exec($chb);
    $error = curl_error($chb);
    $response = curl_getinfo($chb, CURLINFO_HTTP_CODE);
    var_dump($error);
    var_dump($response);
    curl_close($chb);

}elseif ($messagingArray == "fourthlaw"){
    $urlb = "https://graph.facebook.com/v2.6/me/messages?access_token=$accessToken";
$jsonDatab = "{
 'recipient': {
   'id': $userID
 },
 'message': {
 'attachment':{
      'type':'template',
      'payload':{
        'template_type':'button',
        'text': 'We must place our faith in Jesus Christ as Savior in order to receive the gift of salvation and know Gods wonderful plan for our lives. In John 1:12 we read, But to all who did receive him, who believed in his name, he gave the right to become children of God. Acts 16:31 teaches, Believe in the Lord Jesus, and you will be saved. Salvation comes through grace alone, through faith alone, in Jesus Christ alone (Ephesians 2:8-9)',
        'buttons':[
          {
            'type':'postback',
           'title':'Main Menu',
            'payload':'payloadhelp'
          },
          
         
        ]
      }
    }
  }
}";

//curl request for the messageing only
$chb = curl_init($urlb);
curl_setopt($chb, CURLOPT_POST, true);
curl_setopt($chb, CURLOPT_POSTFIELDS, $jsonDatab);
curl_setopt($chb, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

 curl_exec($chb);
    $error = curl_error($chb);
    $response = curl_getinfo($chb, CURLINFO_HTTP_CODE);
    var_dump($error);
    var_dump($response);
    curl_close($chb);
    sendaudio();
}



function sendTextMessage($message, $userID, $accessToken){
    $urls = "https://graph.facebook.com/v2.6/me/messages?access_token=$accessToken";
    
    $jsonDatas = "{
 'recipient': {
   'id': $userID
 },
 'message': {
 'text': '$message'
 }
    }";
$chs = curl_init($urls);
curl_setopt($chs, CURLOPT_POST, true);
curl_setopt($chs, CURLOPT_POSTFIELDS, $jsonDatas);
curl_setopt($chs, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($chs, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($chs, CURLOPT_SSL_VERIFYPEER, false);

 curl_exec($chs);
    $errors = curl_error($chs);
    $responses = curl_getinfo($chs, CURLINFO_HTTP_CODE);
    var_dump($errors);
    var_dump($responses);
    curl_close($chs);
    
}






function sendaudio(){
global $accessToken;
global $userID;

$urls = "https://graph.facebook.com/v2.6/me/messages?access_token=$accessToken";
$jsonDatas = "{
 'recipient': {
   'id': $userID
 },
  'message':{
    'attachment':{
      'type':'audio',
      'payload':{
        'url':'https://hagerigna.com/bot/bornprayer.mp3'
      }
    }
  }
}";
$chs = curl_init($urls);
curl_setopt($chs, CURLOPT_POST, true);
curl_setopt($chs, CURLOPT_POSTFIELDS, $jsonDatas);
curl_setopt($chs, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($chs, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($chs, CURLOPT_SSL_VERIFYPEER, false);

 curl_exec($chs);
    $errors = curl_error($chs);
    $responses = curl_getinfo($chs, CURLINFO_HTTP_CODE);
    var_dump($errors);
    var_dump($responses);
    curl_close($chs);

}


    

        
    

//user types random thing n gets ths message


if(!empty($input['entry'][0]['messaging'][0]['message'])) {
   
  sendTextMessage('I dont understand what you mean by: '.$message.', select an option above!', $userID, $accessToken);
  first_option($userID, $input, $accessToken);
}
   
?>