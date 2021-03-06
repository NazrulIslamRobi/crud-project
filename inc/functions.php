<?php

    define( "DB_NAME", "C:\\Users\\Alpha Net\\Desktop\\crud-project\\data\\db.txt" );

    function seed()
    {

        $data = array(
            array(
                "id"         => 1,
                "name"       => "Nazrul islam",
                "roll"       => "2",
                "department" => "computer",
            ),
            array(
                "id"         => 2,
                "name"       => "Baijid hossain",
                "roll"       => "3",
                "department" => "architecture",
            ),
            array(
                "id"         => 3,
                "name"       => "Rahim",
                "roll"       => "6",
                "department" => "Food",
            ),
            array(
                "id"         => 4,
                "name"       => "Kabir hossain",
                "roll"       => "5",
                "department" => "Mechanical",
            ),
            array(
                "id"         => 5,
                "name"       => "Nikhil Chandra",
                "roll"       => "4",
                "department" => "computer",
            ),
            array(
                "id"         => 6,
                "name"       => "Rabbani",
                "roll"       => "2",
                "department" => "civil",
            ),
        );

        $serializedData = serialize( $data );

        file_put_contents( DB_NAME, $serializedData );

    }

    function studentAdd( $name, $roll, $department )
    {

        $found = false;

        $students = file_get_contents( DB_NAME );

        $unserializeData = unserialize( $students );

        foreach ( $unserializeData as $_student ) {

            if ( $_student['roll'] == $roll ) {

                $found = true;
                break;

            }
        }

        if ( !$found ) {
            $student = array(
                'id'         => getNewId( $unserializeData ),
                'name'       => $name,
                'roll'       => $roll,
                'department' => $department,
            );
            array_push( $unserializeData, $student );

            $serializedData = serialize( $unserializeData );

            file_put_contents( DB_NAME, $serializedData, LOCK_EX );

            return true;
        }

        return false;

    }

    function generateReport()
    {

        $getserializedData = file_get_contents( DB_NAME );

        $data = unserialize( $getserializedData );

    ?>
    <table class="table table-bordered">

    <thead>
    <th>Name</th>
    <th>Roll</th>
    <th>Department</th>
    <?php if(isAdmin() || isEditor()):?>
    <th>Action</th>
    <?php endif; ?>

    </thead>
    <tbody>
        <?php
        foreach ( $data as $student ) {?>
        <tr>
        <td><?=$student['name'];?></td>
        <td><?=$student['roll'];?></td>
        <td><?=$student['department'];?></td>

        <?php if(isAdmin() || isEditor()):?>

            <td><a href="/?task=edit&id=<?=$student['id']?> ">Edit</a>
            <?php if(isAdmin()):?>
            | <a href="/?task=delete&id=<?=$student['id']?>" onclick="return confirm('Are you sure want to delete this?')">Delete</a></td>
            <?php endif;?>
        <?php endif; ?>
        </tr>
       <?php }?>
       

    </tbody>
</table>

<?php }

    function getStudent( $id )
    {

        $serializeData = file_get_contents( DB_NAME );

        $students = unserialize( $serializeData );

        foreach ( $students as $student ) {

            if ( $student['id'] == $id ) {

                return $student;

            }
        }
        return false;

    }

    function studentUpdate( $name, $roll, $department, $id )
    {
        $found = false;

        $serializeData = file_get_contents( DB_NAME );

        $students = unserialize( $serializeData );

        foreach ( $students as $student ) {

            if ( $student['roll'] == $roll && $student['id'] != $id ) {

                $found = true;
                break;

            }
        }

        if ( !$found ) {

            $students[$id - 1]['name']       = $name;
            $students[$id - 1]['roll']       = $roll;
            $students[$id - 1]['department'] = $department;

            $serializedData = serialize( $students );

            file_put_contents( DB_NAME, $serializedData, LOCK_EX );

            return true;
        }
        return false;

    }

    function deleteStudent( $id )
    {

        $serializeData = file_get_contents( DB_NAME );

        $students = unserialize( $serializeData );

        foreach ( $students as $key => $student ) {

            if ( $student['id'] == $id ) {

                unset( $students[$key] );

            }
        }

        $serializeData = serialize( $students );

        file_put_contents( DB_NAME, $serializeData );

    }

    function getNewId( $students )
    {

        $id = max( array_column( $students, 'id' ) );

        return $id + 1;
    }

    function isAdmin() {   

        return ('admin' == $_SESSION['role']);
    }

    function isEditor() {   

        return ('editor' == $_SESSION['role']);
    }

?>

