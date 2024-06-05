Ext.define('Tualo.ai.commands.AskAI', {
    statics: {
      glyph: 'magic',
      title: 'Stapel-AI',
      tooltip: 'Stapel-AI'
    },
    extend: 'Ext.panel.Panel',
    alias: 'widget.tualo_ask_ai',
    layout: 'fit',
    items: [
      {
        xtype: 'form',
        itemId: 'tualo_ask_ai',
        bodyPadding: '25px',
        items: [
          {
            xtype: 'label',
            text: 'Durch Klicken auf *Anwenden* wird eine je Anfrage auf die aktuelle Liste angewendet',
          }
        ]
      }
    ],
    loadRecord: function (record, records, selectedrecords, view) {
      this.record = record;
      this.records = records;
      this.selectedrecords = selectedrecords;
      this.view = view;
      console.log('loadRecord', arguments);
    },
    getNextText: function () {
      return 'Anwenden';
    },
    loop: async function () {
        if (this.loopIndex<this.records.length){
            let res= await fetch('./ai/askproc',{
                method: 'POST',
                body: JSON.stringify(this.records[this.loopIndex].data)
            });
            res = await res.json();
            if (res.success !== true){
                Ext.toast({
                    html: res.msg,
                    title: 'Fehler',
                    align: 't',
                    iconCls: 'fa fa-warning'
                });
            }

            this.loopIndex++;
            this.loop();
        }
          return false;
    },
    run: async function () {
        this.loopIndex=0;
        await this.loop();
     
      return null;
    }
  });
  