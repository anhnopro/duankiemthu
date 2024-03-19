export const sendPHP = (KeyName, value, fetchfrom) => {
    // Tạo một đối tượng JSON có tên thuộc tính là giá trị của KeyName
        const data = {};
        data[KeyName] = value;

        fetch(fetchfrom, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json', // Đảm bảo gửi dữ liệu dưới dạng JSON
            },
            body: JSON.stringify(data), // Gửi đối tượng JSON chứa giá trị
        })
            .then(response => {

                if (response.ok) {
                    location.reload();
                } else {
                    throw new Error('Network response was not ok.');
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    }