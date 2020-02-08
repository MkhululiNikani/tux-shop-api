<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE");

class HttpResponse
{

  public function version(){
    return "1.0.0";
  } 
  public function OK($resultsData)
  {
    http_response_code(200);
    echo json_encode([
      "status_code" => 200,
      "version" => $this->version(),
      "data" => $resultsData
    ]);
  }

  public function badRequest($message)
  {
    http_response_code(400);
    echo json_encode([
      "status_code" => 400,
      "version" => $this->version(),
      "error_type"=> "Bad Request",
      "message" => $message,
    ]);
  }

  public function unauthorized()
  {
    http_response_code(401);
    echo json_encode([
      "status_code" => 401,
      "version" => $this->version(),
      "error_type"=> "Unauthorized",
      "message" => "No valid API key provided.",
    ]);
  }

  public function requestFailed($message)
  {
    http_response_code(402);
    echo json_encode([
      "status_code" => 402,
      "version" => $this->version(),
      "error_type"=> "Request Failed",
      "message" => $message,
    ]);
  }

  public function forbidden()
  {
    http_response_code(403);
    echo json_encode([
      "status_code" => 403,
      "version" => $this->version(),
      "error_type"=> "Forbidden",
      "message" => "The API key doesn't have permissions to perform the request.",
    ]);
  }

  public function notFound($message)
  {
    http_response_code(404);
    echo json_encode([
      "status_code" => 404,
      "version" => $this->version(),
      "error_type"=> "Not Found",
      "message" => $message,
    ]);
  }

  public function serverError()
  {
    http_response_code(500);
    echo json_encode([
      "status_code" => 500,
      "version" => $this->version(),
      "error_type"=> "Internal Server Error",
      "message" => "Something went wrong on our server."
    ]);
  }

}
