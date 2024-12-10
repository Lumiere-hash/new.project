INSERT INTO
    sc_mst.trxtype (kdtrx, jenistrx, uraian)
VALUES (
        'AA2',
        'PASSET',
        'APPROVAL MANAGER'
    ),(
        'AA3',
        'PASSET',
        'APPROVAL RSM'
    ),(
        'AA4',
        'PASSET',
        'APPROVAL GM'
    ),(
        'AA5',
        'PASSET',
        'APPROVAL MANAGER KEUANGAN'
    ),(
        'AA6',
        'PASSET',
        'APPROVAL DIREKSI'
    ),
    (
        'IT',
        'PASSET',
        'INPUT TAMBAHAN SPK'
    )
ON CONFLICT DO NOTHING;
