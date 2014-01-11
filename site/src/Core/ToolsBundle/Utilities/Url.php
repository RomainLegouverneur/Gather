<?php

namespace Core\ToolsBundle\Utilities;

class    Url
{
  private  $protocol;
  private  $subdomain;
  private  $domain;
  private  $port;
  private  $tld;
  private  $path;
  private  $params;

  private function  parseURL($rawUrl)
  {  
    $comp = parse_url($rawUrl);
    if (isset($comp['scheme']))
      $this->protocol = $comp['scheme'];
    if (isset($comp['path']))
      $this->path = $comp['path'];
    if (isset($comp['port']))
      $this->port = $comp['port'];
  if (isset($comp['host']))
  {
      preg_match("#^(([a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)*)\.)*([a-zA-Z0-9_-]+)\.([a-zA-Z0-9]+)$#", $comp['host'], $compHost);
      if (isset($compHost[2]))
          $this->subdomain = $compHost[2];
      if (isset($compHost[4]))
          $this->domain = $compHost[4];
      if (isset($compHost[5]))
          $this->tld = $compHost[5];
  }
    if (isset($comp['query']))
      parse_str($comp['query'], $this->params);
  }

  public function  __construct($rawUrl = NULL)
  {
   if ($rawUrl == NULL)
    $rawUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $this->parseURL($rawUrl);
  }

  public static function getInstance($rawUrl = NULL)
  {
      return new URL($rawUrl);
  }

  public function  setURL($rawUrl)
  {
    $this->parseURL($rawUrl);
  }

  public function  getURL()
  {
    $url = "";
    if ($this->protocol)
      $url .= $this->protocol . '://';
    if ($this->subdomain)
      $url .= $this->subdomain . '.';
  if ($this->domain)
      $url .= $this->domain;
  if ($this->tld)
    $url .= '.' . $this->tld;
    if ($this->port)
      $url .= ':' . $this->port;
    if ($this->path)
      $url .= $this->path;
    if ($query = http_build_query((array)$this->params))
      $url .= '?' . $query;
    return ($url);
  }

  public function  __toString()
  {
    return ($this->getURL());
  }

  public function  __get($attr)
  {
    if (isset($this->$attr))
      return ($this->$attr);
    else
      return (NULL);
  }

  public function       __set($attr, $value)
  {
     if (isset($this->$attr))
      $this->$attr = $value;
  }

  public function  setParam($key, $value)
  {
    $this->params[$key] = $value;
  }

  public function  getParam($key)
  {
    if (isset($this->params[$key]))
      return ($this->params[$key]);
    else
      return (NULL);
  }

  public function  eraseParam($key)
  {
    if (isset($this->params[$key]))
      unset($this->params[$key]);
  }

  public function  setParams($paramsTab)
  {
    foreach ($paramsTab as $key => $value)
      {
    $this->params[$key] = $value;
      }
  }
}
?>