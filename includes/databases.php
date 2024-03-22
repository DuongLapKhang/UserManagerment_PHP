<?php
if (!defined('_CODE')) {
    die ('Access denied...');
}

// Truy vấn
function query($sql, $data = [], $check = false)
{
    global $connect;
    $status = false;
    // echo $sql;
    try {
        $statement = $connect->prepare($sql);
        if (!empty ($data)) {
            $status = $statement->execute($data);
        } else {
            $status = $statement->execute();
        }

    } catch (Exception $exception) {
        echo $exception->getMessage() . "<br>";
        echo "File: " . $exception->getFile() . "<br>";
        echo "Line: " . $exception->getLine() . "<br>";
        die(); // dừng chương trình nếu lỗi
    }

    if ($check) {
        return $statement;
    }

    return $status;
}

// Thêm
function insert($table, $data)
{
    $key = array_keys($data);
    $truong = implode(', ', $key);
    $value_table = ':' . implode(", :", $key);

    $sql = 'insert into ' . $table . '(' . $truong . ')' . 'value(' . $value_table . ')';
    return query($sql, $data);
}

// Cập nhật 
function update($table, $data, $condition = '')
{
    $update = '';
    foreach ($data as $key => $value) {
        $update .= $key . '= :' . $key . ',';
    }
    $update = trim($update, ',');
    if (!empty ($condition)) {
        $sql = 'update ' . $table . ' set ' . $update . ' where ' . $condition;
    } else {
        $sql = 'update ' . $table . ' set ' . $update;
    }
    return query($sql, $data);
}

// Xóa
function delete($table, $condition = '')
{
    if (!empty ($condition)) {
        $sql = 'delete from ' . $table . ' where ' . $condition;
    } else {
        $sql = 'delete from ' . $table;
    }
    return query($sql);
}

// Lấy
// Lấy nhiều dòng dữ liệu
function getAllRow($sql)
{
    $kq = query($sql, '', true);
    if (is_object($kq)) {
        $dataFetch = $kq->fetchAll(PDO::FETCH_ASSOC);
    }
    return $dataFetch;
}

// Lấy 1 dòng dữ liệu
function getOneRow($sql)
{
    $kq = query($sql, '', true);
    if (is_object($kq)) {
        $dataFetch = $kq->fetch(PDO::FETCH_ASSOC);
    }
    return $dataFetch;
}
// Đếm số dòng dữ liệu
function countRow($sql)
{
    $kq = query($sql, '', true);
    if (!empty ($kq)) {
        return $kq->rowCount();
    } else {
        return 0;
    }

}