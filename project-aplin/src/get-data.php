<?php
try {
  $conn = DB::getInstance();

  $query = isset($_GET['query']) ? $_GET['query'] : "";

  $stmt = $conn->prepare($query);
  $stmt->execute();

  $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($data);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
$conn = null;

?>