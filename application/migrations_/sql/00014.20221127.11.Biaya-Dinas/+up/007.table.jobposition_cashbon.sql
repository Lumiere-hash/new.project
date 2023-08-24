DROP TABLE IF EXISTS sc_mst.jobposition_cashbon;
CREATE TABLE IF NOT EXISTS sc_mst.jobposition_cashbon (
    branch VARCHAR NOT NULL,
    jobposition VARCHAR NOT NULL,
    componentid VARCHAR NOT NULL, /* from : sc_mst.component_cashbon.componentid */
    destinationid VARCHAR NOT NULL, /* from : sc_mst.destination_type.destinationid */
    nominal NUMERIC NOT NULL,
    inputby VARCHAR NOT NULL,
    inputdate TIMESTAMP NOT NULL,
    updateby VARCHAR,
    updatedate TIMESTAMP,
    CONSTRAINT jobposition_cashbon_pkey PRIMARY KEY ( branch, jobposition, componentid, destinationid )
);

COMMENT ON COLUMN sc_mst.jobposition_cashbon.componentid IS 'from : sc_mst.component_cashbon.componentid';
COMMENT ON COLUMN sc_mst.jobposition_cashbon.destinationid IS 'from : sc_mst.destination_type.destinationid';

INSERT INTO sc_mst.jobposition_cashbon
(branch, jobposition, componentid, destinationid, nominal, inputby, inputdate)
VALUES
    ('MJKCNI', '03', 'UM', 'LK',90000, 'postgres', NOW()),
    ('MJKCNI', '03', 'UD', 'LK', 40000, 'postgres', NOW()),
    ('MJKCNI', '02-5', 'UM', 'LP', 80000, 'postgres', NOW()),
    ('MJKCNI', '02-5', 'UD', 'DK', 30000, 'postgres', NOW())
ON CONFLICT ( branch, jobposition, componentid, destinationid )
    DO NOTHING;

