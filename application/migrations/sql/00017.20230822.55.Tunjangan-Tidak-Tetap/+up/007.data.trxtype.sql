INSERT INTO sc_mst.trxtype
(kdtrx, jenistrx, uraian)
VALUES
    ('TPB','TRANSPTYPE','PRIBADI'),
    ('TDN','TRANSPTYPE','DINAS')
ON CONFLICT ( kdtrx, jenistrx )
    DO NOTHING;