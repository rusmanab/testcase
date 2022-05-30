    <div class="table-responsive">
    <table class="table table-bordered" id="list-product">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Product Name</th>
                <th>Category Name</th>
                <th>Price</th>
                <th class="text-center">Created at</th>
                <th class="text-center">#</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($data) == 0){ ?>
            <tr>
                <td colspan="6" class="text-center">No data available in table</td>
            </tr>
            <?php } ?>
            <?php
            $no = 0;
            if ($page){
                $limit = 5;
                $no = ($page - 1) * $limit;
            }
            ?>
            @foreach($data as $row)
            <?php $no++?>
            <tr>
            <td class="text-center">{{ $no }}</td>
            <td>{{ $row->product_name }}</td>
            <td>{{ $row->category_name }}</td>
            <td class="text-right"><?php echo number_format($row->price)?></td>
            <td class="text-center">{{ $row->created_at }}</td>
            <td class="text-center">
                <?php
                $route = route('product.edit',[ 'id' =>$row->id]);
                $btn = "<center>";
                $btn = "<a title='Hapus' href='".$route."' class='edit' data-id='".$row->id."' ><span class='fa fa-edit'></span></a> ";
                $btn .= "<a title='Hapus' href='#' class='hapusItem' data-id='".$row->id."' ><span class='fa fa-trash'></span></a>";
                $btn .= "</center>";
                echo $btn;
                ?>
                </td>
            </tr>

            @endforeach
        </tbody>

    </table>
</div>
{!! $data->links() !!}



