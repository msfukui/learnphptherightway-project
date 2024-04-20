create table transactions (
  id serial primary key,
  transaction_date date not null,
  check_number integer,
  description text not null,
  currency_code varchar(3) not null,
  amount numeric(10,2) not null,
  insert_datetime datetime not null
);
