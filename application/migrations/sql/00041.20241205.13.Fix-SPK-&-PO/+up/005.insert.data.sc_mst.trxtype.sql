INSERT INTO
    sc_mst.trxtype (kdtrx, jenistrx, uraian)
VALUES (
        'AA2',
        'PASSET',
        'APPROVAL MANAGER'
    )
ON CONFLICT DO NOTHING;
