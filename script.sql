CREATE TABLE Users (
                       user_id SERIAL PRIMARY KEY,
                       email VARCHAR(255) NOT NULL,
                       telegram_handle VARCHAR(255)
);

CREATE TABLE Requests (
                          request_id SERIAL PRIMARY KEY,
                          user_id INTEGER REFERENCES Users(user_id),
                          start_date DATE NOT NULL,
                          end_date DATE NOT NULL,
                          status TEXT CHECK (status IN ('pending', 'in_progress', 'completed', 'error')) DEFAULT 'pending',
                          created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE Transactions (
                              transaction_id SERIAL PRIMARY KEY,
                              user_id INTEGER REFERENCES Users(user_id),
                              transaction_date TIMESTAMP WITH TIME ZONE NOT NULL,
                              description TEXT,
                              amount NUMERIC(10, 2) NOT NULL,
                              transaction_type TEXT CHECK (transaction_type IN ('credit', 'debit')) NOT NULL
);

-- Insert users
INSERT INTO Users (email, telegram_handle) VALUES
                                               ('user1@example.com', '@user1'),
                                               ('user2@example.com', '@user2'),
                                               ('user3@example.com', '@user3');

DO $$
    DECLARE
user_id INT;
        start_date DATE := '2012-01-01';
        end_date DATE := '2024-03-19';
        curr_date DATE;
BEGIN
FOR user_id IN 1..3 LOOP
                FOR i IN 1..100 LOOP
                        curr_date := start_date + (RANDOM() * (end_date - start_date))::INTEGER;
INSERT INTO Transactions (user_id, transaction_date, description, amount, transaction_type)
VALUES (user_id, curr_date, 'Transaction ' || i, ROUND((RANDOM() * 1000)::NUMERIC, 2),
        CASE WHEN RANDOM() < 0.5 THEN 'debit' ELSE 'credit' END);
END LOOP;
END LOOP;
END $$;
