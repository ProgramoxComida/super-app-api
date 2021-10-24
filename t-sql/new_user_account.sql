DELIMITER //

CREATE TRIGGER after_users_insert
    AFTER INSERT
    ON users FOR EACH ROW
BEGIN
    -- Account
    INSERT INTO accounts(users_id, available-limit, active, created_at) VALUES (new.id, 0.00, 1, NOW());
    -- User Rank
    INSERT INTO user_rank(ranks_id, users_id, created_at) VALUES(1, new.id, NOW());
    -- Missions
    DECLARE done INT DEFAULT FALSE;
    DECLARE ids INT;
    DECLARE cur CURSOR FOR SELECT id FROM missions;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    OPEN cur;
    ins_loop: LOOP
        FETCH cur INTO ids;
        IF done THEN
            LEAVE ins_loop;
        END IF;

        INSERT INTO user_missions VALUE (NEW.id, ids, 'started', NOW(), null);
    END LOOP;
    CLOSE cur;
END; //
DELIMITER ;
