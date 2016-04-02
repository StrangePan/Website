CREATE TABLE IF NOT EXISTS `Pages` (
	ID BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Parent BIGINT DEFAULT NULL,
    Type BIGINT,
	Title VARCHAR(256) NOT NULL,
	Alias VARCHAR(256) NOT NULL,
    
    CHECK (Parent <> ID),
    CHECK (Title <> ''),
    CHECK (ALIAS <> ''),
    CHECK (Alias = LOWER(Alias)),
    CHECK (Alias = REPLACE(Alias, ' ', '-')),
    
    UNIQUE KEY ind_pages_parent_alias
        USING BTREE (Parent, Alias),
    
    CONSTRAINT fk_pages_pages
        FOREIGN KEY (Parent)
        REFERENCES Pages(ID)
        ON DELETE SET NULL ON UPDATE CASCADE,
    
    CONSTRAINT fk_pages_type
        FOREIGN KEY (Type)
        REFERENCES PageTypes(ID)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;
