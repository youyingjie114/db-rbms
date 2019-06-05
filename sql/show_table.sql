/*
 * 1. 显示各表格
 * 2. 构造show_products()函数用于显示products表格
 */ 

-- 构造存储过程，用于显示任意表格
DROP PROCEDURE IF EXISTS show_table;
CREATE PROCEDURE show_table(IN table_name VARCHAR(30))
BEGIN
SET @sql = CONCAT('SELECT * FROM ', table_name);  -- 将table_name传入，动态拼接sql查询语句
PREPARE stmt FROM @sql;
EXECUTE stmt;
END;

-- 构造存储过程，用于显示products表格
DROP PROCEDURE IF EXISTS show_products;
CREATE PROCEDURE show_products()
BEGIN
SELECT * FROM products;
END;

-- 测试
CALL show_table('products');
CALL show_products();

