INSERT INTO
    sc_mst.trxtype (kdtrx, jenistrx, uraian)
VALUES (
        'AA2',
        'PASSET',
        'APPROVAL MANAGER'
    ),
    (
        'IT',
        'PASSET',
        'INPUT TAMBAHAN SPK'
    )
ON CONFLICT DO NOTHING;
