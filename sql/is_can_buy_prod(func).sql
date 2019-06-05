/*
 * 返回对应产品的库存数量
 * 让前端判断是否可以购买该产品
 */

drop function if exists is_can_buy_prod;
CREATE FUNCTION is_can_buy_prod (p_id VARCHAR(4), num INT(5)) RETURNS INT
BEGIN
DECLARE prod_num INT;
DECLARE flag INT DEFAULT 0;
SELECT prod.qoh INTO prod_num
FROM products prod
WHERE prod.pid = p_id;
IF (num <= prod_num) THEN   -- 若订单数量<=商品库存，该商品可以购买
  SET flag = 1;
ELSE
  SET flag = 0;
END IF;
RETURN flag;
END;

-- 测试
SELECT is_can_buy_prod('pr00', 10);