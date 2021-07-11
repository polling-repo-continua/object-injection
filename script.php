<?php

$classlist = get_declared_classes();

// credits: visnuk
// discord: visnukzone#2222

$mapmagic = array("__wakeup", "__destruct", "__toString", "__get", "__set", "__call");

foreach($classlist as $class)
{
  $reflClass = new ReflectionClass($class);
  if ($reflClass->isUserDefined())
  {
    foreach($mapmagic as $method)
    {
      try
      {
        if ($reflClass->getMethod($method))
        {
          $reflMethod = new ReflectionMethod($class, $method);
          $parent = $reflMethod->getDeclaringClass()->getName();
          $filename = $reflMethod->getDeclaringClass()->getFileName();
          $startline = $reflMethod->getStartLine();

          if ($filename(
            {
              $exp = $reflMethod->export($class, $method, 1);
              preg_match("/@@\s(.*)\s(\d+)\s-\s(\d+)/i", $exp, $matches);
              $source = file($filename);

              $functionBody = implode("", array_slice($source, $matches[2] - 1, ($matches[3]-$matches[2] + 1)));


              if(preg_match("/eval|assert|call_user_func|system|popen|shell_exec|include|require|file_get_contents|unlink|exec/",
                           $functionBody, $m))
              {
                $interesting = $m[0];
              }
              print $class . "::" . $method . "() ";
              if ($parent !== $class)
              {
                print "[extends " . $parent . "] ";
              }
              if (isset($intersting))
              {
                print "{calls " . $intersting . "} ";
                unset($interesting);
              }

              print "- " . $filename . ':' . $startline . "\n" . "<br>";
            }
            }
            }
            catch (Exception $e) {}
            }
            }
            }
            exit;
?>
