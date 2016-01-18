<?php

namespace User\Mapper;

interface UserFileMapperInterface
{
    /**
     * @param $user
     * @param $dataSourceGlobal
     *
     * @return object
     */
    public function getFies($user, $dataSourceGlobal);

    /**
     * @param $user
     *
     * @return int
     */
    public function getNotDownloadedFilesCount($user);

    /**
     * @param \User\Entity\User                $user
     * @param \Utility\Entity\DataSourceGlobal $dataSourceGlobal
     * @param                                  $path
     * @param                                  $filename
     */
    public function saveFileData(
        \User\Entity\User $user,
        \Utility\Entity\DataSourceGlobal $dataSourceGlobal,
        $path,
        $filename
    );

    /**
     * @param $filePath
     * @param $filename
     *
     * @return object
     */
    public function incrementFileCounter($filename, $filePath);
}
