-- 1. 添加 Job_id 字段
ALTER TABLE Rating ADD COLUMN Job_id INT NOT NULL AFTER Users_id;

-- 2. 添加外键约束 (确保 Job_id 必须存在于 Job 表)
ALTER TABLE Rating ADD CONSTRAINT fk_rating_job 
FOREIGN KEY (Job_id) REFERENCES Job(id) 
ON DELETE CASCADE;

-- 3. (可选) 删除旧的 Job_Agreement_id 字段，防止混淆
-- 如果里面有旧数据想保留，可以先跳过这一步
ALTER TABLE Rating DROP FOREIGN KEY fk_Rating_Job_Agreement1; -- 先删外键约束
ALTER TABLE Rating DROP COLUMN Job_Agreement_id;              -- 再删字段